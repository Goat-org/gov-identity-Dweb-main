<?php
  include('admin_connection.php');
  
  //1.determine page number
  if(isset($_GET['pagenumber']) && $_GET['pagenumber'] != ""){
    //if user has already entered page then page number is the one that they selected
    $pagenumber = $_GET['pagenumber'];
  }
  else{
    //if user just entered the page then default page is 1
    $pagenumber = 1;
  }

  //2. return number of logs
  $stmt = $conn->prepare("SELECT COUNT(*) AS fldtotalrecords FROM audit_logs");
  $stmt->execute();
  $stmt->bind_result($totalrecords);
  $stmt->store_result();
  $stmt->fetch();

  //3. determine a specific number of logs to display per page
  $totalrecordsperpage = 10;
  $offset = ($pagenumber - 1) * $totalrecordsperpage;
  $previouspage = $pagenumber - 1;
  $nextpage = $pagenumber + 1;
  $adjacents = "2";
  $totalnumberofpages = ceil($totalrecords / $totalrecordsperpage);

  //4. get all logs
  $stmt1 = $conn->prepare("SELECT * FROM audit_logs LIMIT $offset,$totalrecordsperpage");
  $stmt1->execute();
  $logs = $stmt1->get_result();// This is an array
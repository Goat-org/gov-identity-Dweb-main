<?php
include("includes/admin_header.php");
//if user is not logged in then take user to login page
if(!isset($_SESSION['adminEmail'])){
  header('location: admin_login.php?error=Unauthorised Access. Please Login.');
  exit;
}
?>
<body>
    <header>
        <h1>Home Affairs Admin: Review Civil Registrations</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_review_citizenship_applications.php">Review Citizenship Applications</a>
        <a href="admin_review_visa_applications.php">Review Visa Applications</a>
        <a href="admin_review_id_applications.php">Review ID Applications</a>
        <a href="admin_view_users.php">View Users</a>
        <a href="admin_audit_logs.php">Audit Logs</a>
        <?php if(isset($_SESSION['adminEmail'])){ ?>
            <form id="admin-logout-form" method="POST" action="admin_review_civil_registrations.php">
                <a><button type="submit" class="logoutBtn" id="adminLogoutBtn" name="adminLogoutBtn">Logout</button></a>
            </form>
        <?php } ?>
    </nav>
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <h2>Civil Registration List</h2>
        <table>
            <thead>
                <tr>
                    <th>Registration No.</th>
                    <th>Full Name</th>
                    <th>Registration Type</th>
                    <th>Date of Event</th>
                    <th>Status</th>
                    <th>Submission Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php include('server/get_admin_review_civil_registrations.php');
                        foreach($registrations as $registration){?>
                <tr>
                    <td><?php echo $registration['civil_registration_id']; ?></td>
                    <td><?php echo $registration['civil_registration_full_name']; ?></td>
                    <td><?php echo $registration['civil_registration_type']; ?></td>
                    <td><?php echo $registration['civil_registration_date_of_event']; ?></td>
                    <td><?php echo $registration['civil_registration_status']; ?></td>
                    <td><?php echo $registration['civil_registration_created_at']; ?></td>
                    <td>
                        <a href="admin_verify_civil_registration.php?id=<?php echo $registration['civil_registration_id']; ?>" class="verify-button">Verify</a>
                        <a href="admin_approve_civil_registration.php?id=<?php echo $registration['civil_registration_id']; ?>" class="action-button">Approve</a>
                        <a href="admin_deny_civil_registration.php?id=<?php echo $registration['civil_registration_id']; ?>" class="action-button">Deny</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="page-btn">
            <span class="page-item <?php if($pagenumber <= 1){ echo 'disabled';} ?>"><a class="page-link" href="<?php if($pagenumber <= 1){ echo '#';}else{ echo "?pagenumber=".($pagenumber - 1);} ?>">Prev</a></span>

            <span class="page-item"><a class="page-link" href="?pagenumber=1">1</a></span>
            <span class="page-item"><a class="page-link" href="?pagenumber=2">2</a></span>

            <?php if($pagenumber >= 3) { ?>
                <span class="page-item"><a class="page-link" href="#">...</a></span>
                <span class="page-item"><a class="page-link" href="<?php echo "?pagenumber=".$pagenumber; ?>"><?php echo $pagenumber; ?></a></span>
            <?php } ?>

            <span class="page-item <?php if($pagenumber >= $totalnumberofpages){ echo 'disabled';} ?>"><a class="page-link" href="<?php if($pagenumber >= $totalnumberofpages){ echo '#';}else{ echo "?pagenumber=".($pagenumber + 1);} ?>">Next</a></span>
        </div>
    </main>
</body>
<?php
include("includes/admin_footer.php");
?>
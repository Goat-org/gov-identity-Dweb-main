<?php
session_start();

if (isset($_POST['logoutBtn'])) {
    unset($_SESSION['firstName']);
    unset($_SESSION['surname']);
    unset($_SESSION['email']);
    header('location: login.php');
    exit;
}

// Setting CSP header
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'https://cdn.ethers.io' 'sha256-...' 'nonce-...'; style-src 'self';");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.ethers.io/lib/ethers-5.0.umd.min.js"></script>
    <title>Home Affairs</title>
</head>
<body>
    <!-- Your page content -->
</body>
</html>


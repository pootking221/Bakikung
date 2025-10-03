<?php
session_start();
// ถ้าไม่มี session ให้ redirect ไป login
if (!isset($_SESSION['user'])) {
    header("Location: \dashboard/miniProject/users/login.php");
    exit;
}

$user = $_SESSION['user'];
$page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="\dashboard/miniProject/assets/bootstrap/css/bootstrap.min.css">
    <script src="\dashboard/miniProject/assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Kanit", sans-serif;
            font-weight: 300;
            font-style: normal;
        }
    </style>


    <!-- <script src="\dashboard/miniProject/assets/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <!-- <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css"> -->
</head>



<!-- Sidebar -->
<nav class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark vh-100" style="width: 250px;  position: fixed; top: 0; left: 0;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
            <use xlink:href="#bootstrap"></use>
        </svg>
        <span class="fs-4">SBS Phee.</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="\dashboard/miniProject/index.php" class="nav-link text-white <?php if ($page == "index.php") echo 'active'; ?>">
                Home
            </a>
        </li>
        <li>
            <a href="\dashboard/miniProject/pages/donation.php" class="nav-link text-white <?php if ($page == "donation.php") echo 'active'; ?>">
                Donation List
            </a>
        </li>
        <li>
            <a href="\dashboard/miniProject/pages/management_donation.php" class="nav-link text-white <?php if ($page == "request.php") echo 'active'; ?>">
                My Requests
            </a>
        </li>

        <li>
            <a href="\dashboard/miniProject/pages/management_donation.php" class="nav-link text-white <?php if ($page == "management_donation.php") echo 'active'; ?>">
                Give Donation
            </a>
        </li>

        <li>
            <a href="\dashboard/miniProject/pages/donation_approvals.php" class="nav-link text-white <?php if ($page == "donation_approvals.php") echo 'active'; ?>">
                Donation Approvals
            </a>
        </li>





    </ul>
    <hr>
    <div>
        <strong><?php echo $user['firstname'] . " " . $user['lastname']; ?></strong>
        <div>SID: <?php echo $user['student_id']; ?></div>
        <a class="text-primary text-decoration-none" href="\dashboard/miniProject/actions/logout.php">Sign out</a>
    </div>
</nav>
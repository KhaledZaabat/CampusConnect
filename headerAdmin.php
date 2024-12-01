<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home</title> <!-- Static title for the Home page -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- bootstrap -->
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css"> <!-- fonts -->
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- custom css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
</head>



<header>
    <nav class="navbar navbar-expand-lg fixed-top bg-body clean-navbar">
        <div class="container">
            <a class="navbar-brand-logo" href="#">
                <img class="logo_img" src="assets/img/logo.png" alt="Brand Logo"> 
            </a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item active"><a class="nav-link" href="AdminHome.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="AdminNews.php">News</a></li>
                    <li class="nav-item"><a class="nav-link" href="CanteenManagement.php">Canteen Schedule</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li class="dropdown-header">Maintenance Services</li>
                            <li><a class="dropdown-item" href="ReceivingIssues.php">Manage Issues</a></li>
                            <li><a class="dropdown-item" href="lostfound.php">Lost&Found items</a></li>
                            <li class="dropdown-header">Housing Services</li>
                            <li><a class="dropdown-item" href="#">Book Rooms</a></li>
                            <li><a class="dropdown-item" href="roomRequests.php">Change Rooms</a></li>
                            <li class="dropdown-header">Users</li>
                            <li><a class="dropdown-item" href="crudstud.php"> Manage Students</a></li>
                            <li><a class="dropdown-item" href="crudadmin.php"> Manage Employees</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="dropdown d-none d-lg-block me-3">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="UserProfile.php">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
                <ul class="navbar-nav d-lg-none">
                    <li><hr class="dropdown-divider my-1"></li>
                    <li class="nav-item"><a class="nav-link" href="StudentProfile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Sign out</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>


<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</html>
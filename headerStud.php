<?php

if (!isset($_SESSION['user']['Id'])) {
    header("Location: Login.php");  // Redirect to login page if not logged in
    exit();
}


$studentId = $_SESSION['user']['Id'] ;
if ($studentId && $_SESSION['user']['isStud']===true) {
    require 'db_connection.php';
    // Fetch the image path based on the student ID
    $stmt = $conn->prepare("SELECT img_path FROM student WHERE Id = ?");
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc(); // Get associative array
    
    if ($user && isset($user['img_path'])) {
        $imgPath = $user['img_path'];
    } 
    $stmt->close();
} else {
    die("you are employee hhhhh"); 
}

?>

<script src="assets/js/navbar.js"></script>
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
                    <li id="nav-item" class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li id="nav-item" class="nav-item"><a class="nav-link" href="news.php">News</a></li>
                    <li id="nav-item" class="nav-item"><a class="nav-link" href="Canteen.php">Canteen Schedule</a></li>
                    <li id="nav-drop" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li class="dropdown-header">Maintenance Services</li>
                            <li><a class="dropdown-item" href="ReportIssues.php">Report Issues</a></li>
                            <li><a class="dropdown-item" href="lostfound.php">Lost&Found items</a></li>
                            <li class="dropdown-header">Housing Services</li>
                            <li><a class="dropdown-item" href="BookRoom.php">Book Rooms</a></li>
                            <li><a class="dropdown-item" href="changeRoom.php">Change Rooms</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Profile section for PC -->
                <div class="dropdown d-none d-lg-block me-3">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo htmlspecialchars($imgPath); ?>" alt="Profile Picture" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="StudentProfile.php">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Sign out</a></li> <!-- Sign out link -->
                    </ul>
                </div>

                <!-- Profile and Sign-out links for smaller screens (phone) -->
                <ul class="navbar-nav d-lg-none">
                    <li><hr class="dropdown-divider my-1"></li>
                    <li class="nav-item"><a class="nav-link" href="StudentProfile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Sign out</a></li> <!-- Sign out link -->
                </ul>
            </div>
        </div>
    </nav>
</header>


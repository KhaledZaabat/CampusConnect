<?php
// Start session to get the logged-in student ID

// Database configuration
require 'db_connection.php';

// Assuming student ID is stored in session
$userid = $_SESSION['user']['Id'] ;
if ($userid) {
    // Fetch the image path based on the student ID
    $stmt = $conn->prepare("SELECT img_path FROM employee WHERE Id = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc(); // Get associative array
    
    if ($user && isset($user['img_path'])) {
        $imgPath = $user['img_path'];
        // Check if the file exists
        if (!$imgPath || !file_exists($imgPath)) {
            $imgPath = "assets/img/gens.png"; // Default profile image
        }
    } else {
        $imgPath = "assets/img/gens.png"; // Default profile image if no image found
    }
    $stmt->close();
} else {
    // Default image if no student ID is available
    $imgPath = "assets/img/gens.png";
}
?>

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
                        <img src="<?php echo htmlspecialchars($imgPath); ?>" alt="mdo" width="32" height="32" class="rounded-circle">
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
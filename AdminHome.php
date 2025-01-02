<?php
session_start();
if ($_SESSION['user']['Role'] !== 'Admin'){
    die("just admins can access this page");
}
require 'headerAdmin.php';

// Fetch total students in dorms
$sql_students = "SELECT COUNT(*) AS total_students FROM student";
$result_students = $conn->query($sql_students);

// Check if the query was successful
if ($result_students) {
    $row_students = $result_students->fetch_assoc();
    // Ensure total_students is an integer
    $total_students = intval($row_students['total_students']);
} else {
    // Handle query failure
    echo "Error: " . $conn->error;
}

$active_requests = 5 ;

// Fetch the total number of rooms
$sql_room_availability = "SELECT COUNT(*) AS total_rooms FROM room";
$result_room_availability = $conn->query($sql_room_availability);
$row_room_availability = $result_room_availability->fetch_assoc();
$total_rooms = intval($row_room_availability['total_rooms']);  // Ensure it's an integer

// Fetch the total number of students where room is not null
$sql_students_in_rooms = "SELECT COUNT(*) AS students_in_rooms FROM student WHERE roomId IS NOT NULL";
$result_students_in_rooms = $conn->query($sql_students_in_rooms);
$row_students_in_rooms = $result_students_in_rooms->fetch_assoc();
$total_students_in_rooms = intval($row_students_in_rooms['students_in_rooms']);  // Ensure it's an integer

// Calculate the room availability percentage
$room_availability_percentage = round((($total_rooms - $total_students_in_rooms) / $total_rooms) * 100);  // Ensure the calculation is correct

$sql_room_requests = "SELECT COUNT(*) AS total_room_requests FROM roomrequest";
$result_room_requests = $conn->query($sql_room_requests);

// Check if the query was successful
if ($result_room_requests) {
    $row_room_requests = $result_room_requests->fetch_assoc();
    $total_room_requests = intval($row_room_requests['total_room_requests']);
} else {
    // Handle query failure
    echo "Error: " . $conn->error;
}

$sql_issues = "SELECT COUNT(*) AS total_issues FROM issue";
$result_issues = $conn->query($sql_issues);

// Check if the query was successful
if ($result_issues) {
    $row_issues = $result_issues->fetch_assoc();
    $total_issues = intval($row_issues['total_issues']);
} else {
    // Handle query failure
    echo "Error: " . $conn->error;
}

$sql_employees = "SELECT COUNT(*) AS total_employees FROM employee";
$result_employees = $conn->query($sql_employees);
$row_employees = $result_employees->fetch_assoc();
$total_employees = $row_employees['total_employees'];


$conn->close();
?>



<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/HOME.css">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <script src="assets/js/Home.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
</head>


<body>
    <main class="page">
        <div class="container mt-5">
            <div class="header content">
                <p>
                    <span class="Welcome">Admin Dashboard of</span><br>
                    <span class="project-name" id="animated-text"></span>
                </p>
                <p class="welcome-paragraph">Manage students, organize services, and streamline operations for a better campus experience.</p>
            </div>

           <!-- Stats Section -->
<div class="stats-section content">
    <div class="row text-center">
        <!-- First row with 3 columns -->
        <div class="col-lg-4 col-md-4 mb-4">
            <i class="fas fa-user-check stat-icon"></i>
            <h3 class="stat-counter" data-target="<?php echo $total_students; ?>"></h3>
            <p>Students in Dorms</p>
        </div>
        <div class="col-lg-4 col-md-4 mb-4">
            <i class="fas fa-users stat-icon"></i>
            <h3 class="stat-counter" data-target="<?php echo $total_employees; ?>"><?php echo $total_employees; ?></h3>
            <p>Employees</p>
        </div>
        <div class="col-lg-4 col-md-4 mb-4">
            <i class="fas fa-bed stat-icon"></i>
            <h3 class="stat-counter" data-target="<?php echo $total_room_requests; ?>"></h3>
            <p>Room Requests</p>
        </div>
    </div>
    <div class="row text-center">
        <!-- Second row with 2 centered columns -->
        <div class="col-lg-4 col-md-6 mb-4 offset-lg-2">
            <i class="fas fa-tools stat-icon"></i>
            <h3 class="stat-counter" data-target="<?php echo $total_issues; ?>"></h3>
            <p>Active Maintenance Requests</p>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <i class="fas fa-door-open stat-icon"></i>
            <h3 class="stat-counter" data-target="<?php echo $room_availability_percentage; ?>"></h3>
            <p>Room Availability (%)</p>
        </div>
    </div>
</div>



            <!-- Admin Management Section -->
            <div class="services-section ">
                <div class="services-title">
                    <span class="bold-text">Our Services.</span>
                    <span class="regular-text">Crafting a seamless experience through innovation and care.</span>
                </div>
                <div class="services-blocks">
                    <div class="service-block filter content">
                        <i class="fas fa-users service-icon"></i>
                        <h3>Manage Users</h3>
                        <p>Oversee Users registrations, accommodations, and profiles.</p>
                        <div class="card-btn-container">
                            <a href="crudstud.php"><div class="card-btn">Manage Students</div></a>
                            <a href="crudadmin.php"><div class="card-btn">Manage Employees</div></a>
                        </div>
                    </div>
                    
                    <div class="service-block filter content">
                        <i class="fas fa-utensils service-icon"></i>
                        <h3>Manage Canteen Menu</h3>
                        <p>Update and organize daily canteen menus for the students.</p>
                        <div class="card-btn-container">
                            <a href="CanteenManagement.php"><div class="card-btn">Manage Menu</div></a>
                        </div>
                    </div>
                    
                    <div class="service-block filter content">
                        <i class="fas fa-newspaper service-icon"></i>
                        <h3>Manage News</h3>
                        <p>Create and publish campus news and announcements.</p>
                        <div class="card-btn-container">
                            <a href="AdminNews.php"><div class="card-btn">Update News</div></a>
                        </div>
                    </div>
                    
                    <div class="service-block filter content">
                        <i class="fas fa-screwdriver-wrench service-icon"></i>
                        <h3>Manage Other Services</h3>
                        <p>Oversee maintenance requests, housing services, and more.</p>
                        <div class="card-btn-container">
                            <a href="changeRoom.php"><div class="card-btn">Manage Rooms</div></a>
                            <a href="ReceivingIssues.php"><div class="card-btn">Students Issues</div></a>
                        </div>
                    </div>
                </div>
                
            </div>
            
    </main>

    <div class="footer-spacing"></div> <!-- Spacing before the footer -->

    <?php include 'footer.php' ?>
</body>


</html>

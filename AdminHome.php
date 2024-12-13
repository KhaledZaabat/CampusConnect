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
    <?php include 'headerAdmin.php' ?>
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
                    <div class="col-lg-4 col-md-6 mb-4">
                        <i class="fas fa-user-check stat-icon"></i>
                        <h3 class="stat-counter" data-target="900">+0</h3>
                        <p>Students in Dorms</p>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <i class="far fa-bed stat-icon"></i>
                        <h3 class="stat-counter" data-target="150">+0</h3>
                        <p>Beds Available</p>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <i class="fas fa-bed stat-icon"></i>
                        <h3 class="stat-counter" data-target="750">+0</h3>
                        <p>Beds Occupied</p>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <i class="fas fa-tools stat-icon"></i>
                        <h3 class="stat-counter" data-target="5">+0</h3>
                        <p>Active Maintenance Requests</p>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <i class="fas fa-door-open stat-icon"></i>
                        <h3 class="stat-counter" data-target="85">+0</h3>
                        <p>Room Availability (%)</p>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <i class="fas fa-thumbs-up stat-icon"></i>
                        <h3 class="stat-counter" data-target="4.5">0</h3>
                        <p>Average Satisfaction</p>
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

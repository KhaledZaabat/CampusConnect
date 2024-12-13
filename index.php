<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home</title> <!-- Static title for the Home page -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- bootstrap -->
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css"> <!-- fonts -->
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- custom css -->
    <link rel="stylesheet" href="assets/css/HOME.css"> <!-- custom css -->
    <script src="assets/js/navbar.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Home.js"></script>

    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <!-- font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
</head>



<body>
<?php include 'headerStud.php' ?>
    <main class="page">
        <div class="container mt-5">
            <!-- Header Section -->
            <div class="header content">
                <p>
                    <span class="Welcome">Welcome to your</span><br>
                    <span class="project-name" id="animated-text"></span><!-- ID for the animation -->
                </p>
                <p class="welcome-paragraph">Your gateway to vibrant dorm life. Discover services, connect with our community, and stay informed.</p>
            </div>

            <!-- News Section -->
            <div class="News-Home content">
                <div class="services-title">
                    <span class="bold-text">The Latest.</span>
                    <span class="regular-text">Take a look at what's new.</span>
                </div>

                <div class="news-cards content">
                    <div class="card content">
                        <img src="assets/img/logo.png" class="card-img-top" alt="Brand Logo">
                        <div class="card-body">
                            <span class="card-date">October 12, 2024</span>
                            <h5 class="card-title">News One</h5>
                            <p class="card-text">Get the latest updates on dorm activities, events, and important announcements.</p>
                            <a href="newsDetails.php" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>

                    <div class="card content">
                        <img src="assets/img/logo.png" class="card-img-top" alt="Brand Logo">
                        <div class="card-body">
                            <span class="card-date">October 11, 2024</span>
                            <h5 class="card-title">News Two</h5>
                            <p class="card-text">Manage your dorm room services and stay on top of your requests with ease.</p>
                            <a href="newsDetails.php" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>

                    <div class="card content">
                        <img src="assets/img/pic5.jpg" class="card-img-top" alt="News Image">
                        <div class="card-body">
                            <span class="card-date">October 10, 2024</span>
                            <h5 class="card-title">News Three</h5>
                            <p class="card-text">Connect with fellow students and stay engaged with dorm life activities.</p>
                            <a href="newsDetails.php" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>

                </div>
                  <!-- Add a "View All News" button here -->
                  <a href="news.php" class="btn-view-all-news">
                    View All News <span class="arrow">→</span>
                </a>
            </div>

            <!-- Services Section -->
            <div class="services-section content">
                <div class="services-title content">
                    <span class="bold-text">Our Services.</span>
                    <span class="regular-text">Crafting a seamless experience through innovation and care.</span>
                </div>
                <div class="services-blocks content">
                    
                    <a class="noUnderLine" href="BookRoom.php">
                        <div class="service-block content">
                            <i class="fas fa-bed service-icon"></i>
                            <h3>Room Booking</h3>
                            <p>Book rooms and spaces within the dorm for your events and activities with ease.</p>
                        </div>
                    </a>
                    
                    <a class="noUnderLine" href="Canteen.php">
                        <div class="service-block content">
                            <i class="fas fa-utensils service-icon"></i>
                            <h3>Food & Dining</h3>
                            <p>Explore a variety of dining options and order your meals right from your dorm.</p>
                        </div>
                    </a>
                    
                    <a class="noUnderLine" href="ReportIssues.php">
                        <div class="service-block content">
                            <i class="fas fa-tools service-icon"></i>
                            <h3>Maintenance Requests</h3>
                            <p>Submit requests for any issues or repairs needed in your living space.</p>
                        </div>
                    </a>
                    
                    <a class="noUnderLine" href="lostfound.php">
                        <div class="service-block content">
                            <i class="fas fa-search service-icon"></i>
                            <h3>Lost & Found</h3>
                            <p>Stay updated on social and educational events happening around the dorm.</p>
                        </div>
                    </a>
                    

                </div>
            </div>
        </div>

    </main>


    <div class="footer-spacing"></div> <!-- Spacing before the footer -->
    <?php include 'footer.php' ?>
</body>





</html>

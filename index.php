<?php
// Database connection
require 'headerStud.php';

// Fetch the last 3 news items sorted by date in descending order
$sql = "SELECT * FROM news ORDER BY Date DESC LIMIT 3";
$result = $conn->query($sql);

// Check if there are any news items
$news_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $news_items[] = $row; // Store each row into the $news_items array
    }
} else {
    $news_items = null; // Set to null to handle the "no news" case in the HTML
}

$conn->close();
?>



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
        <?php if ($news_items): ?>
            <?php foreach ($news_items as $news): ?>
                <div class="card content">
                <div class="card-body">
    <span class="card-date"><?php echo date("F j, Y", strtotime($news['Date'])); ?></span>
    <h5 class="card-title"><?php echo htmlspecialchars($news["title"]); ?></h5>
    <p class="card-text">
        <?php 
        $content = $news['content']; 
        // Check if the content starts with an HTML tag like <img> or <table>
        if (preg_match('/^\s*<(img|table)[^>]*>/i', $content)) {
            // Content starts with <img> or <table>; display a placeholder text
            echo "Content includes a media or table, click 'Learn More' to view.";
        } else {
            // Strip HTML tags and truncate plain text
            $plain_text = strip_tags($content);
            echo strlen($plain_text) > 100 
                ? substr($plain_text, 0, 100) . '...' 
                : $plain_text;
        }
        ?>
    </p>
    <a href="newsDetails.php?id=<?php echo htmlspecialchars($news['Id']); ?>" class="btn btn-primary">Learn More</a>
</div>


                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No news available at the moment.</p>
        <?php endif; ?>
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

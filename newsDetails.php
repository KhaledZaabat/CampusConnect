<?php

// Get news ID from URL parameter
if (isset($_GET['id'])) {
    $newsId = intval($_GET['id']); // Prevent SQL injection
    // Your code to handle $newsId here
} else {
    // Handle the case where 'Id' is not set
    echo "Error: Missing or invalid parameter.";
    exit; // Optional: Stop further execution if necessary
}
require 'db_connection.php';
session_start();

if ( $_SESSION['user']['isStud'] === true) {
    require 'headerStud.php';
} else {
    require 'headerAdmin.php';
}

// SQL query to fetch news details by ID
$sql = "SELECT * FROM news WHERE id = $newsId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>

    <!DOCTYPE html>
    <html data-bs-theme="light" lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>News Details</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/newsDetails.css">
        <link rel="icon" href="assets/img/logo.png" type="image/png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">

    </head>
    <body>

    <header class="news-header text-center">
        <h1 class="news-title"><?php echo htmlspecialchars($row["title"]); ?></h1>
        <div class="news-header-date">
            <?php echo date("F j, Y", strtotime($row["Date"])); ?>
        </div>
    </header>

    <div class="container mt-4 news-content-container">
    <div class="news-content">
        <?php
        // Display content directly without htmlspecialchars to render HTML
        echo nl2br($row["content"]);
        ?>
    </div>
  </div>

    <?php if (!empty($row["FILE"])): ?>
        <div class="file-section">
            <h4>Download the file:</h4>
            <a href="<?php echo $row["FILE"]; ?>" download>
                <?php echo basename($row["FILE"]); ?>
                <i class="fa fa-download"></i> <!-- Download icon -->
            </a>
        </div>
    <?php endif; ?>

    <?php include 'footer.php'; ?>
    </body>
    </html>

    <?php
} else {
    echo "News not found.";
}
?>

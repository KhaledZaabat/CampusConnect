<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>NewsAdmin</title> <!-- Static title for the Home page -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- bootstrap -->
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css"> <!-- fonts -->
    <link rel="stylesheet" href="assets/css/Rooms.css"> <!-- custom css -->
    <link rel="stylesheet" href="assets/css/ReportIssues.css"> <!-- custom css -->
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- custom css -->
    <link rel="stylesheet" href="assets/css/News.css"> <!-- custom css -->

    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <!-- font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
</head>


<body>
    <?php include 'headerAdmin.php' ?>
    <div class="news-header">
        <h1>News</h1>
        <div class="News-header-content">
            Stay Connected With The Latest Happenings and Essential Updates Across the University.
        </div>
    </div>

    <div class="container mt-4">
        <div class="search-container">
            <input type="text" id="search-input" class="search-input" placeholder="Search news...">
            <button id="search-button" class="search-button">Search</button>
        </div>
    </div>

    <div id="news-container" class="news-container"></div>

    <div id="pagination-controls" class="pagination-controls"></div>
    <a href="AddNews.html" class="fixed-button">+</a>
    <?php include 'footer.php' ?>
</body>




<script src="assets/bootstrap/js/bootstrap.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="assets/js/NewsAdmin.js"></script>

</html>
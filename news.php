<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>News</title> <!-- Static title for the Home page -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- bootstrap -->
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css"> <!-- fonts -->
    <link rel="stylesheet" href="assets/css/Rooms.css"> <!-- custom css -->
    <link rel="stylesheet" href="assets/css/ReportIssues.css"> <!-- custom css -->
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- custom css -->
    <link rel="stylesheet" href="assets/css/News.css">


    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <!-- font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <script src="assets/js/navbar.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<?php 
session_start();

require 'headerStud.php';

?>
    <div class="news-header">
        <h1>News</h1>
        <div class="News-header-content">Stay Connected With The Lastest Happeneings and essentail updates across the
            university . </div>
    </div>
    <div class="container mt-4">
        <div class="search-container">
            <input type="text" id="search-input" class="search-input" placeholder="Search news...">
            <button id="search-button" class="search-button">Search</button>
        </div>
    </div>

    <div id="news-container" class="news-container"></div>
   
    
    </div>
    <!-- Pagination Controls -->
<div id="pagination-controls" class="text-center mt-4">
    <!-- Pagination buttons will be dynamically inserted here -->
</div>
<?php include 'footer.php' ?>


</body>


<script src="assets/js/NewsJs.js"></script>


</html>
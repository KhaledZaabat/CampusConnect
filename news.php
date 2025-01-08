<?php 
session_start();
if ($_SESSION['user']['Role'] === 'Admin'){
    require 'headerAdmin.php';
}
else if ($_SESSION['user']['Role'] === null){
    require 'headerStud.php';
}
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>NewsAdmin</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/News.css">
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <style>
        .news-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }
        .news-actions a {
            text-decoration: none;
        }
        .Edit , .Delete{
            transition : all .5s ;
        }
        .Edit:hover {
    color: blue;
    border: none;
    background: none;
    cursor: pointer;
}

.Delete:hover {
    color: red;
    border: none;
    background: none;
    cursor: pointer;
}
.pagination-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin: 20px 0;
    flex-wrap: wrap;
}

.pagination-controls button {
    padding: 8px 16px;
    border: 1px solid #ddd;
    background-color: white;
    cursor: pointer;
    border-radius: 4px;
    transition: all 0.2s;
    min-width: 40px;
}

.pagination-controls button:not(.active) {
    background-color:rgb(0, 27, 54);
    border-color: #0d6efd;
    color: #0d6efd;
}

.pagination-controls button.active {
    background-color: #0d6efd;
    color: white;
    border-color: #0d6efd;
    cursor: default;
}

.no-results {
    text-align: center;
    padding: 40px;
    color: #6c757d;
    font-size: 1.1em;
}

       
    </style>
</head>

<body>
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

    <div id="news-container" class="news-container">
        <?php
        require 'db_connection.php';
        $sql = "SELECT * FROM news ORDER BY Date DESC";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<div class='news-item'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<small>Published on: " . htmlspecialchars($row['Date']) . "</small>";
            if ($_SESSION['user']['Role'] === 'Admin') {
                echo "<div class='news-actions'>";
                echo "<a href='AddNews.php?id=" . $row['Id'] . "' class='Edit'>Edit</a>";
                echo "  |  ";
                echo "<a href='#' data-id='" . $row['Id'] . "' class='Delete'>Delete</a>";
                echo "</div>";
            }
            echo "</div>";
        }
        ?>
    </div>

    <div id="pagination-controls" class="pagination-controls"></div>

    <?php
    if ($_SESSION['user']['Role'] === 'Admin') { ?>
        <a href="AddNews.php" class="fixed-button">+</a>
    <?php } ?>

    <?php include 'footer.php' ?>
</body>

<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/NewsAdmin.js"></script>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Admin - Room Change Requests</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
        <!-- Fonts -->
        <link rel="stylesheet" href="assets/css/styles.css"> <!-- Custom CSS -->
        <link rel="stylesheet" href="assets/css/roomRequest.css">
        <!-- Custom CSS -->
        <link rel="icon" href="assets/img/logo.png" type="image/png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">

</head>


    
<body>
<?php include 'headerAdmin.php' ?>

    <!-- Room Change Requests -->
    <div class="table-container">
        <div class="dropdown mb-3 text-end">
            <a class="dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-filter"></i>Filter
            </a>
            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                <li><a class="dropdown-item filterDropdown" data-filter="Pending" href="#">Pending</a></li>
                <li><a class="dropdown-item filterDropdown" data-filter="Approved" href="#">Approved</a></li>
                <li><a class="dropdown-item filterDropdown" data-filter="Rejected" href="#">Rejected</a></li>
                <li><a class="dropdown-item filterDropdown" data-filter="All" href="#">All</a></li>
            </ul>
        </div>
        
        <h2>Room Change Requests</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="custom-head"> 
                    <th id="table-head">Student Name</th>
                    <th id="table-head">Current Room</th>
                    <th id="table-head">Requested Room</th>
                    <th id="table-head">Reason</th>
                    <th id="table-head">Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="requestTableBody">
            </tbody>
        </table>

        <div id="pagination" class="d-flex justify-content-center mt-3">
        </div>
    </div>
    <?php include 'footer.php' ?>

</body>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/roomsrequests.js"></script>
    <script src="assets/js/helperFunctions.js"></script>


</html>

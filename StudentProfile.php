<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Student Profile</title>
 




    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Canteen</title> <!-- Static title for the Home page -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- bootstrap -->
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css"> <!-- fonts -->
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- custom css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/StudentProfile.css">
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <!-- font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <script src="assets/js/navbar.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    
</head>


<body>
<?php include 'headerStud.php' ?>

    <div class="container-xl px-4 mt-4">
        <hr class="mt-0 mb-4">
        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <img id="profilePicture" class="img-account-profile rounded-circle mb-2" src="" alt="Profile Image">
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form id="profileForm">
                            <div class="mb-3">
                                <label class="small mb-1" for="inputFirstName">First Name</label>
                                <input class="form-control" id="inputFirstName" type="text" maxlength="20" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputLastName">Last Name</label>
                                <input class="form-control" id="inputLastName" type="text" maxlength="20" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputStudentID">Student ID</label>
                                <input class="form-control" id="inputStudentID" type="text" maxlength="10" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmail">Email</label>
                                <input class="form-control" id="inputEmail" type="email" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputPhone">Phone Number</label>
                                <input class="form-control" id="inputPhone" type="tel" maxlength="15" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputRoomNumber">Room Number</label>
                                <input class="form-control" id="inputRoomNumber" type="text" maxlength="5" readonly>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/StudetnProfile.js"></script>
    <?php include 'footer.php' ?>

</body>





</html>

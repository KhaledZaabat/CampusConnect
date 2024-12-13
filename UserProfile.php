<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>User Profile</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="assets/css/StudentProfile.css">
    <script src="assets/js/navbar.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
</head>



<body>
<?php include 'headerAdmin.php' ?>

    <div class="container-xl px-4 mt-4">
        <hr class="mt-0 mb-4">
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <img class="img-account-profile rounded-circle mb-2" src="assets/img/test.jpg" alt="Profile Image">
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputFirstName">First Name</label>
                                <input class="form-control" id="inputFirstName" type="text" value="John" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputLastName">Last Name</label>
                                <input class="form-control" id="inputLastName" type="text" value="Doe" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputUserID">User ID</label>
                                <input class="form-control" id="inputUserID" type="text" value="123456" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmail">Email</label>
                                <input class="form-control" id="inputEmail" type="email" value="johndoe@email.com" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputPhone">Phone Number</label>
                                <input class="form-control" id="inputPhone" type="tel" value="+1234567890" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputRole">Role</label>
                                <input class="form-control" id="inputRole" type="text" value="Chef" readonly>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-spacing"></div> <!-- Spacing before the footer -->
    <?php include 'footer.php' ?>

</body>



</html>

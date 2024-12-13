
<?php
require 'db_connection.php'; // Include your database connection
$message = ""; // For displaying success messages
$errors = []; // To hold validation errors

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_SESSION['user']['Id']; // Assume student_id is stored in session
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    // Validate current password
    if (empty($currentPassword)) {
        $errors['currentPassword'] = 'Current password is required.';
    }

    // Validate new password length
    if (strlen($newPassword) < 8) {
        $errors['newPassword'] = 'New password must be at least 8 characters long.';
    }

    // Validate password confirmation
    if ($newPassword !== $confirmNewPassword) {
        $errors['confirmNewPassword'] = 'Passwords do not match.';
    }

    // Process password change if no errors
    if (empty($errors)) {
        // Fetch the current hashed password from the database
        $query = $conn->prepare("SELECT password FROM student WHERE id = ?");
        $query->bind_param("s", $studentId);
        $query->execute();
        $result = $query->get_result();
        $user = $result->fetch_assoc();

        if (!$user || !password_verify($currentPassword, $user['password'])) {
            $errors['currentPassword'] = 'Current password is incorrect.';
        } else {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            // Update the password in the database
            $update = $conn->prepare("UPDATE student SET password = ? WHERE id = ?");
            $update->bind_param("ss", $hashedPassword, $studentId);

            if ($update->execute()) {
                $message = "Password changed successfully!";
            } else {
                $errors['general'] = 'Error: Could not update password.';
            }
        }
    }
}
?>
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
        <!-- Profile Picture Section -->
        <div class="col-xl-4">
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <img id="profilePicture" class="img-account-profile rounded-circle mb-2" src="" alt="Profile Image">
                </div>
            </div>
        </div>
        
        <!-- Account Details Section -->
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

            <!-- Password Change Section -->
            <div class="card mb-4">
                <div class="card-header">Change Password</div>
                <div class="card-body">
                <form id="changePasswordForm" method="POST" action="">
    <?php if (!empty($message)): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <?php if (!empty($errors['general'])): ?>
        <div class="alert alert-danger"><?= $errors['general'] ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <label class="small mb-1" for="currentPassword">Current Password</label>
        <input class="form-control <?= isset($errors['currentPassword']) ? 'is-invalid' : '' ?>" 
               id="currentPassword" 
               name="currentPassword" 
               type="password">
        <?php if (isset($errors['currentPassword'])): ?>
            <div class="invalid-feedback"><?= $errors['currentPassword'] ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label class="small mb-1" for="newPassword">New Password</label>
        <input class="form-control <?= isset($errors['newPassword']) ? 'is-invalid' : '' ?>" 
               id="newPassword" 
               name="newPassword" 
               type="password">
        <?php if (isset($errors['newPassword'])): ?>
            <div class="invalid-feedback"><?= $errors['newPassword'] ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label class="small mb-1" for="confirmNewPassword">Confirm New Password</label>
        <input class="form-control <?= isset($errors['confirmNewPassword']) ? 'is-invalid' : '' ?>" 
               id="confirmNewPassword" 
               name="confirmNewPassword" 
               type="password">
        <?php if (isset($errors['confirmNewPassword'])): ?>
            <div class="invalid-feedback"><?= $errors['confirmNewPassword'] ?></div>
        <?php endif; ?>
    </div>

    <button class="btn btn-primary" type="submit">Change Password</button>
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

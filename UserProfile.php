
<?php
require 'db_connection.php'; // Include your database connection
$message = ""; // For displaying success messages
$errors = []; // To hold validation errors

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = $_SESSION['user']['Id']; 
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
        $query = $conn->prepare("SELECT password FROM employee WHERE id = ?");
        $query->bind_param("s", $employeeId);
        $query->execute();
        $result = $query->get_result();
        $user = $result->fetch_assoc();

        if (!$user || !password_verify($currentPassword, $user['password'])) {
            $errors['currentPassword'] = 'Current password is incorrect.';
        } else {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            // Update the password in the database
            $update = $conn->prepare("UPDATE employee SET password = ? WHERE id = ?");
            $update->bind_param("ss", $hashedPassword, $employeeId);

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

    <div class="footer-spacing"></div> <!-- Spacing before the footer -->
    <?php include 'footer.php' ?>

</body>



</html>

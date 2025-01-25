<?php
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'campus_connect';
$username = 'root';
$password = '';

// Initialize error variable
$error = "";

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$message = ""; // For displaying success messages
$errors = []; // To hold validation errors

if (!isset($_SESSION['user']['Id'])) {
    die("Unauthorized access.");
}

$employeeId = $_SESSION['user']['Id'];

// Fetch user profile data from the database
$query = $conn->prepare("SELECT firstName, lastName, Email, Phone, img_path, Role FROM employee WHERE id = ?");
if (!$query) {
    die("Query preparation failed: " . $conn->error);
}

$query->bind_param("s", $employeeId);
$query->execute();
$result = $query->get_result();

if ($result && $result->num_rows > 0) {
    $profileData = $result->fetch_assoc();
} else {
    $errors['general'] = "Failed to load user profile data.";
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $currentPassword = $_POST['currentPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmNewPassword = $_POST['confirmNewPassword'] ?? '';
    
    if (empty($currentPassword)) {
        $errors[] = 'Current password is required.';
    }
    if (strlen($newPassword) < 8) {
        $errors[] = 'New password must be at least 8 characters long.';
    }
    if ($newPassword !== $confirmNewPassword) {
        $errors[] = 'Passwords do not match.';
    }
    if ($currentPassword === $newPassword) {
        $errors[] = 'New password cannot be the same as the current password.';
    }

    if (empty($errors)) {
        // Fetch the current password from the database
        $query = $conn->prepare("SELECT password FROM employee WHERE Id = ?");
        if ($query) {
            $query->bind_param("s", $employeeId);
            $query->execute();
            $result = $query->get_result();
            $user = $result->fetch_assoc();

            if (!$user) {
                $errors[] = 'User not found in the database.';
            } elseif (!password_verify($currentPassword, $user['password'])) {
                $errors[] = 'Current password is incorrect.';
            } else {
                // Update the password
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $update = $conn->prepare("UPDATE employee SET password = ? WHERE id = ?");
                if ($update) {
                    $update->bind_param("ss", $hashedPassword, $employeeId);
                    if ($update->execute()) {
                        $message = "Password changed successfully!";
                    } else {
                        $errors[] = 'Could not update password. Database error: ' . $conn->error;
                    }
                } else {
                    $errors[] = 'Failed to prepare the update query. Error: ' . $conn->error;
                }
            }
        } else {
            $errors[] = 'Failed to prepare the select query. Error: ' . $conn->error;
        }
    }

    // Return JSON response with concatenated errors if any
    header('Content-Type: application/json');
    if (!empty($errors)) {
        echo json_encode(['errors' => implode(' | ', $errors)]);
    } else {
        echo json_encode(['message' => $message]);
    }
    exit;
}



?>



<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>User Profile</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- bootstrap -->
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css"> <!-- fonts -->
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- custom css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <script src="assets/js/navbar.js"></script>
    <link rel="stylesheet" href="assets/css/StudentProfile.css">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
</head>



<body>
<?php require 'headerAdmin.php'; ?>

    <div class="container-xl px-4 mt-4">
        <hr class="mt-0 mb-4">
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card -->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <img class="img-account-profile rounded-circle mb-2"
                            src="<?= !empty($profileData['img_path']) ? $profileData['img_path'] : 'assets/img/default.jpg'; ?>"
                            alt="Profile Image">
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Account details card -->
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputFirstName">First Name</label>
                                <input class="form-control" id="inputFirstName" type="text"
                                    value="<?= $profileData['firstName'] ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputLastName">Last Name</label>
                                <input class="form-control" id="inputLastName" type="text"
                                    value="<?= $profileData['lastName'] ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmail">Email</label>
                                <input class="form-control" id="inputEmail" type="email"
                                    value="<?= $profileData['Email'] ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputPhone">Phone Number</label>
                                <input class="form-control" id="inputPhone" type="tel"
                                    value="<?= $profileData['Phone'] ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputRole">Role</label>
                                <input class="form-control" id="inputRole" type="text"
                                    value="<?= $profileData['Role'] ?>" readonly>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">Change Password</div>
                    <div class="card-body">
                        <form id="changePasswordForm" method="POST" action="">
                            <div id="responseMessage"></div>

                            <div class="mb-3">
                                <label class="small mb-1" for="currentPassword">Current Password</label>
                                <input class="form-control" id="currentPassword" name="currentPassword" type="password">
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1" for="newPassword">New Password</label>
                                <input class="form-control" id="newPassword" name="newPassword" type="password">
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1" for="confirmNewPassword">Confirm New Password</label>
                                <input class="form-control" id="confirmNewPassword" name="confirmNewPassword"
                                    type="password">
                            </div>

                            <button class="btn btn-primary" type="submit">Change Password</button>
                        </form>
                    </div>
                </div>
            
                </div>
            </div>

        </div>
    </div>

    <div class="footer-spacing"></div> <!-- Spacing before the footer -->
    <?php include 'footer.php' ?>


    <script>
        document.getElementById("changePasswordForm").addEventListener("submit", function (event) {
    event.preventDefault();

    const form = this;
    const formData = new FormData(form);
    const responseMessage = document.getElementById("responseMessage");

    responseMessage.innerHTML = "";

    fetch("", {
        method: "POST",
        body: formData
    })
    .then(response => {
        // Ensure response is parsed as JSON
        return response.json();
    })
    .then(data => {
        if (data.errors) {
            // If errors exist, show danger alert
            responseMessage.innerHTML = `<div class="alert alert-danger">${data.errors}</div>`;
        } else if (data.message) {
            // If message exists, show success alert
            responseMessage.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            // Optional: reset form after successful password change
            form.reset();
        }
    })
    .catch(error => {
        console.error("Detailed Error:", error);
        responseMessage.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
    });
});
    </script>
</body>



</html>
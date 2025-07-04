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
$message = "";
$errors = [];

if (!isset($_SESSION['user']['Id'])) {
    die("Unauthorized access.");
}

$studentId = $_SESSION['user']['Id'] ; // Check if the session variable exists

// Fetch Student profile data from the database
$query = $conn->prepare("SELECT firstName, lastName, Email, Phone, img_path, roomId FROM student WHERE id = ?");
if (!$query) {
    die("Query preparation failed: " . $conn->error);
}

$query->bind_param("s", $studentId);
$query->execute();
$result = $query->get_result();

if ($result && $result->num_rows > 0) {
    $profileData = $result->fetch_assoc();
} else {
    $errors['general'] = "Failed to load user profile data.";
}
//Getting room number
$query = $conn->prepare("
    SELECT 
        CONCAT(b.blockName, f.FloorNumber, r.RoomNumber) AS roomNumber
    FROM 
        student s
    JOIN 
        room r ON s.roomId = r.Id
    JOIN 
        floor f ON r.FloorID = f.Id
    JOIN 
        block b ON f.BlockID = b.Id
    WHERE 
        s.Id = ?
");

if ($query) {
    $query->bind_param("s", $studentId);
    $query->execute();
    $result = $query->get_result();
    if ($result && $result->num_rows > 0) {
        $roomData = $result->fetch_assoc();
        $roomNumber = $roomData['roomNumber'] ?? 'N/A';
    } else {
        $roomNumber = 'Room data not found.';
    }
} else {
    die("Query preparation failed: " . $conn->error);
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
        $query = $conn->prepare("SELECT password FROM student WHERE Id = ?");
        if ($query) {
            $query->bind_param("s", $studentId);
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
                $update = $conn->prepare("UPDATE student SET password = ? WHERE id = ?");
                if ($update) {
                    $update->bind_param("ss", $hashedPassword, $studentId);
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

require 'headerStud.php';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/StudentProfile.css">
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <!-- font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <script src="assets/js/navbar.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

</head>


<body>


    <div class="container-xl px-4 mt-4">
        <hr class="mt-0 mb-4">
        <div class="row">
            <!-- Profile Picture Section -->
            <div class="col-xl-4">
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <img id="profilePicture" class="img-account-profile rounded-circle mb-2"
                            src="<?= htmlspecialchars($profileData['img_path'] ?? 'default-profile.png') ?>"
                            alt="Profile Image">
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
                                <input class="form-control" id="inputFirstName" type="text" maxlength="20" readonly
                                    value="<?= htmlspecialchars($profileData['firstName'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputLastName">Last Name</label>
                                <input class="form-control" id="inputLastName" type="text" maxlength="20" readonly
                                    value="<?= htmlspecialchars($profileData['lastName'] ?? '') ?>">

                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputStudentID">Student ID</label>
                                <input class="form-control" id="inputStudentID" type="text" maxlength="10" readonly
                                    value="<?= htmlspecialchars($studentId ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmail">Email</label>
                                <input class="form-control" id="inputEmail" type="email" readonly
                                    value="<?= htmlspecialchars($profileData['Email'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputPhone">Phone Number</label>
                                <input class="form-control" id="inputPhone" type="tel" maxlength="15" readonly
                                    value="<?= htmlspecialchars($profileData['Phone'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputRoomNumber">Room Number</label>
                                <input class="form-control" id="inputRoomNumber" type="text" maxlength="5"
                                    value="<?= htmlspecialchars($roomNumber) ?>">
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Password Change Section -->
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
                </form>


            </div>
        </div>
    </div>
    </div>
    </div>
    <script src="assets/js/StudetnProfile.js"></script>
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

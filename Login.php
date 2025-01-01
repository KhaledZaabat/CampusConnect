<?php
require 'db_connection.php';

// Start session

// Function to check role and redirect accordingly
function checkUserRoleAndRedirect($role) {
    switch ($role) {
        case 'Admin':
            header("Location: AdminHome.php");
            break;
        case 'chef':
            header("Location: CanteenManagement.php");
            break;
        case 'housing':
            header("Location: roomRequests.php");
            break;
        case 'maintenance':
            header("Location: ReceivingIssues.php");
            break;
    }
    exit();
}

// Get form data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['validated']) && $_POST['validated'] === 'true') {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    // Check user credentials in 'student' table
    $sql = "SELECT * FROM student WHERE Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['Password'])) {
            $_SESSION['user'] = $user; // Store user in session
            header("Location: index.php"); // Redirect students to index.php
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        // Check user credentials in 'Employee' table
        $sql = "SELECT * FROM Employee WHERE Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Verify password
            if ($password === $user['Password']) {
                $_SESSION['user'] = $user; // Store employee in session
                checkUserRoleAndRedirect($user['Role']); // Check role and redirect
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "Invalid user.";
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Connect</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
</head>
<body>
    <?php if (!empty($error)) { ?>
        <script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "<?= $error ?>",
            });
        </script>
    <?php } ?>

    <form id="loginForm" class="login-form" method="POST">
        <input type="hidden" name="validated" value="true">
        <div class="logo-login">
            <img src="assets/img/logo.png" alt="Campus Connect Logo">
        </div>
        <h3 class="title-login">Campus Connect</h3>

        <label for="username" class="login-username-label">Username</label>
        <input type="text" placeholder="202332151212" name="username" id="username" class="input-login">

        <div class="password-container">
            <label for="password" class="login-password-label">Password</label>
            <input type="password" placeholder="Password" name="password" id="password" class="input-login">
            <span class="password-icon">
                <i class="fas fa-eye-slash"></i>
            </span>
        </div>
        <button type="submit" class="submit login-button">Log In</button>
    </form>

    <script>
        // Password show/hide toggle
        const passwordInput = document.getElementById("password");
        const passwordIcon = document.querySelector(".password-icon i");

        passwordIcon.addEventListener("click", function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.classList.remove("fa-eye-slash");
                passwordIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                passwordIcon.classList.remove("fa-eye");
                passwordIcon.classList.add("fa-eye-slash");
            }
        });
    </script>
</body>
</html>

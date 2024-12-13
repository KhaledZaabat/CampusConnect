<?php
// Database configuration
$host = 'localhost';
$dbname = 'campus_connect';
$username = 'root';
$password = '';

// Start session
session_start();

// Initialize error variable
$error = "";

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to check role and redirect accordingly
function checkUserRoleAndRedirect($role) {
    switch ($role) {
        case 'admin':
            header("Location: AdminHome.php");
            break;
        case 'chef':
            header("Location: ManageCanteen.php");
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
            $_SESSION['user'] = $user;
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
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
</head>
<body>
    <form id="loginForm" class="login-form" method="POST">
        <div class="logo-login">
            <img src="assets/img/logo.png" alt="Campus Connect Logo">
        </div>
        <h3 class="title-login">Campus Connect</h3>

        <label for="username" class="login-username-label">Username</label>
        <input type="text" placeholder="202332151212" name="username" id="username" class="input-login">
        
        <?php if (!empty($error)) { ?>
            <span class="error-message"><?= $error ?></span>
        <?php } ?>

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

        passwordIcon.addEventListener("click", function() {
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

        // Username validation function
        function validateUsername() {
            const username = document.getElementById("username").value;
            const regex = /^\d{9,}$/; // Ensure it's 9 digits or more
            
            if (regex.test(username)) {
                return true; // Valid input
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "The Username must be at least 9 digits!"
                }); // Show error message as an alert
                return false; // Invalid input, prevent form submission
            }
        }

        // Password validation function
        function validatePassword() {
            const pswrd = document.getElementById("password").value;
            const regex = /^[A-Za-z].{7,}$/; // Password starts with a letter and has at least 8 characters
            
            if (regex.test(pswrd)) {
                return true; // Valid input
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "The password must be at least 8 characters!"
                }); // Show error message as an alert
                return false; // Invalid input
            }
        }
        
        // Form validation function
        function validateForm() {
            return validateUsername() && validatePassword();
        }
    </script>
</body>
</html>

<?php
session_start();

if ($_SESSION['user']['Role'] !== 'Admin'){
    die("just admins can access this page");
}
require 'headerAdmin.php';
// Variables for success/error messages
$successMessage = "";
$errorMessage = "";

// Handle adding/updating user data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_POST['UserID'] ?? '';
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $password = $firstName . " " . $lastName ;
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    if (isset($_POST['update'])) {
        // Update the employee
        $stmt = $conn->prepare("UPDATE employee SET firstName = ?, lastName = ?, Email = ?, Phone = ?, Role = ? WHERE Id = ?");
        $stmt->bind_param("ssssss", $firstName, $lastName, $email, $phone, $role, $userId);

        if ($stmt->execute()) {
            $successMessage = "Employee updated successfully!";
        } else {
            $errorMessage = "Error updating employee.";
        }
    } else {
        // Insert the new employee record
        $checkStmt = $conn->prepare("SELECT Id FROM employee WHERE Id = ?");
        $checkStmt->bind_param("s", $userId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        if ($result->num_rows > 0) {
            $errorMessage = "User ID already exists. Please use a different User ID.";
        } else {
           // File upload validation
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('Error uploading image.');</script>";
        exit;
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "<script>alert('Invalid file type. Please upload an image.');</script>";
        exit;
    }


    // Directory to store uploaded images
    $uploadDir = 'uploads/profile_pics/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Generate unique file name and save image
    $fileName = $userId . '_' . time() . '.' . $fileExtension;
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
        
                $stmt = $conn->prepare("INSERT INTO employee (Id, firstName, lastName, Email, Role, Phone, Password, img_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss", $userId, $firstName, $lastName, $email, $role, $phone, $hashedPassword , $filePath);
                
                if ($stmt->execute()) {
                    $successMessage = "Employee added successfully!";
                    $_POST = []; // clear form
                } else {
                    $errorMessage = "Error adding employee.";
                }
                $stmt->close();
            } else {
                $errorMessage = "Error uploading image.";
            }
        }
    }
    $checkStmt->close();
}

// If editing an employee
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $editStmt = $conn->prepare("SELECT * FROM employee WHERE Id = ?");
    $editStmt->bind_param("s", $edit_id);
    $editStmt->execute();
    $editResult = $editStmt->get_result();
    $userToEdit = $editResult->fetch_assoc();
} 

// Fetch employees for the employee list
$employees = $conn->query("SELECT Id, firstName, lastName, Email, Role, Phone, img_path FROM employee");
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>CRUD User</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/crud.css">
    <style>
        .delete {
    color: #dc3545;
    font-size: 13px;
    background: none;
    border: none;
    cursor: pointer;
    transition: transform 0.3s, color 0.3s;
}

.delete:hover {
    color: #000000;
    transform: scale(1.2);
    background: none ;
}
    </style>
</head>

<body>
<div class="container2">
    <h1>Employee Management</h1>
    
    <!-- Success Message -->
    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post" class="student-form admin-form" enctype="multipart/form-data">
        <input type="text" placeholder="User ID" name="UserID" id="ID">
        <input type="text" placeholder="First Name" name="firstName">
        <input type="text" placeholder="Last Name" name="lastName">
        <input type="text" placeholder="Email" name="email">
        <input type="tel" placeholder="Phone Number (0xxx...)" name="phone">
        <label for="role"></label>
        <select id="role" name="role">
            <label for="role">Role</label>
            <option value="Maintenance">Maintenance</option>
            <option value="Housing">Housing</option>
            <option value="Chef">Chef</option>
            <option value="Admin" selected>Admin</option>
        </select>
        <div class="form-group mt-2">
            <label for="file" class="custom-file-upload">
                <div class="icon" id="upload-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="..." fill="#007bff"></path>
                    </svg>
                </div>
                <div class="text" id="upload-text"><span>Click to upload image</span></div>
                <input id="file" type="file" name="image" accept="image/*" onchange="previewImage(event)">
            </label>
            <div id="image-preview" style="display: none; margin-top: 10px;">
                <img id="preview-img" src="" alt="Image Preview" style="max-width: 100px; max-height: 100px;">
                <p>Image uploaded!</p>
            </div>
        </div>
        <button type="submit" class="btn_submit">Add User</button>
    </form>
</div>

<script>
    <?php if ($successMessage): ?>
        Swal.fire({
            title: "Success!",
            text: "<?php echo $successMessage; ?>",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            document.querySelector('form').reset();
        });
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        Swal.fire({
            title: "Error",
            text: "<?php echo $errorMessage; ?>",
            icon: "error",
            confirmButtonText: "OK"
        });
    <?php endif; ?>
</script>

<!-- Employee List Table -->
<div class="container3">
    <h1>Employees</h1>
    <div class="search-container">
        <button type="button" class="search-icon"><i class="fas fa-search"></i></button>
        <input type="text" class="search-bar" placeholder="Search by role or last name">
    </div>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="admin-table-body">
    <?php if ($employees->num_rows > 0): ?>
        <?php while ($row = $employees->fetch_assoc()): ?>
            <tr data-user-id="<?php echo $row['Id']; ?>"> <!-- Add this attribute -->
                <td><img src="<?php echo htmlspecialchars($row['img_path']); ?>" alt="<?php echo htmlspecialchars($row['firstName']); ?>" class="student-img"></td>
                <td><input type="text" id="userID" class="tableinput idinput" value="<?php echo htmlspecialchars($row['Id']); ?>" disabled></td>
                <td><input type="text"id="Fname" class="tableinput name" value="<?php echo htmlspecialchars($row['firstName']); ?>" disabled></td>
                <td><input type="text" id="Lname" class="tableinput name Lname" value="<?php echo htmlspecialchars($row['lastName']); ?>" disabled></td>
                <td><input type="text" id="email" class="tableinput emailinput" value="<?php echo htmlspecialchars($row['Email']); ?>" disabled></td>
                <td><input type="text" id="phone" class="tableinput phone" value="<?php echo htmlspecialchars($row['Phone']); ?>" disabled></td> 
                <td>
                    <select class="tableinput roleinput" id="role" disabled>
                        <option value="Maintenance" <?php echo $row['Role'] == 'Maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                        <option value="Housing" <?php echo $row['Role'] == 'Housing' ? 'selected' : ''; ?>>Housing</option>
                        <option value="Chef" <?php echo $row['Role'] == 'Chef' ? 'selected' : ''; ?>>Chef</option>
                        <option value="Admin" <?php echo $row['Role'] == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </td>
                <td>
                    <div class="button-container">
                        <a href="editEmployee.php?userId=<?php echo htmlspecialchars($row['Id']); ?>" class="btn edit"><i class="fas fa-edit"></i></a>
                        <form action="deleteEmployee.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this employee?')">
                            <input type="hidden" name="userId" value="<?php echo $row['Id']; ?>">
                            <button type="submit" id="deleteButton" class="delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="8">No employees found.</td></tr>
    <?php endif; ?>
</tbody>
    </table>
    <!-- Pagination -->
    <div class="pagination">
        <button id="prevpage" disabled><i class="fas fa-arrow-left"></i></button>
        <span id="page-num">1</span>
        <button id="nextpage"><i class="fas fa-arrow-right"></i></button>
    </div>
</div>
<?php include 'footer.php'; ?>
<!-- Scripts -->
<script src="assets/js/crud.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/helperFunctions.js"></script>
</body>
</html>

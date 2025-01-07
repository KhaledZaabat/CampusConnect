<?php
// Include database connection file
require 'db_connection.php';
session_start();

if ( $_SESSION['user']['Role'] !== 'Admin'){
    die("just admins can access this page");
}
require 'headerAdmin.php';
// Ensure 'userId' parameter is passed via the URL for editing
if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];

    // Fetch existing employee data from the database based on the user ID
    $stmt = $conn->prepare("SELECT * FROM employee WHERE Id = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
    $stmt->close();

    if (!$employee) {
        echo "Employee not found!";
        exit;
    }
}

// Handle the form submission to update the employee data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the updated data from the form
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    // Process image upload
    if ($_FILES['image']['error'] === 0) {
        $imgPath = "assets/img/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imgPath);
    } else {
        // Keep the old image if no new one was uploaded
        $imgPath = $employee['img_path'];
    }

    // Update the employee information in the database
    $updateStmt = $conn->prepare("UPDATE employee SET firstName = ?, lastName = ?, Email = ?, phone = ?, Role = ?, img_path = ? WHERE Id = ?");
    $updateStmt->bind_param("sssssss", $firstName, $lastName, $email, $phone, $role, $imgPath, $userId);
    
    if ($updateStmt->execute()) {
        echo "Employee updated successfully!";
        header("Location: crudadmin.php"); // Redirect back to the employee list or success page
        exit;
    } else {
        echo "Error updating employee.";
    }

    $updateStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>CRUD User</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/crud.css">
    <link rel="icon" href="assets/img/logo.png" type="image/png">
</head>

<body>
    <div class="container2">
        <h1>Edit Employee</h1>

        <!-- The form for editing the employee -->
        <form action="" method="POST" class="student-form admin-form" enctype="multipart/form-data">
                <input type="text" id="userId" class="form-control" value="<?php echo htmlspecialchars($employee['Id']); ?>" disabled>
                <input type="text" id="firstName" class="form-control" name="firstName" value="<?php echo htmlspecialchars($employee['firstName']); ?>" required>            
                <input type="text" id="lastName" class="form-control" name="lastName" value="<?php echo htmlspecialchars($employee['lastName']); ?>" required>
                <input type="email" id="email" class="form-control" name="email" value="<?php echo htmlspecialchars($employee['Email']); ?>" required>
                <input type="text" id="phone" class="form-control" name="phone" value="<?php echo htmlspecialchars($employee['phone']); ?>" required>
                <select id="role" class="form-control" name="role">
                    <option value="Maintenance" <?php echo ($employee['Role'] == 'Maintenance') ? 'selected' : ''; ?>>Maintenance</option>
                    <option value="Housing" <?php echo ($employee['Role'] == 'Housing') ? 'selected' : ''; ?>>Housing</option>
                    <option value="Chef" <?php echo ($employee['Role'] == 'Chef') ? 'selected' : ''; ?>>Chef</option>
                    <option value="Admin" <?php echo ($employee['Role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            <div class="form-group mt-2">
                <label for="file" class="custom-file-upload">
                <div class="icon" id="upload-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="..." fill="#007bff"></path>
                </svg>
                </div>
            <div class="text" id="upload-text">
            <span>Click to upload image</span>
            </div>
        <input id="file" type="file" name="image" accept="image/*" onchange="previewImage(event)">
                </label>
    
    <?php if ($employee['img_path']): ?>
        <div id="image-preview" style="display: block; margin-top: 10px;">
            <img id="preview-img" src="<?php echo htmlspecialchars($employee['img_path']); ?>" alt="Employee Image" style="max-width: 100px; max-height: 100px;">
            <p>Image uploaded!</p>
        </div>
    <?php else: ?>
        <div id="image-preview" style="display: none; margin-top: 10px;">
            <img id="preview-img" src="" alt="Image Preview" style="max-width: 100px; max-height: 100px;">
            <p>Image uploaded!</p>
        </div>
    <?php endif; ?>
    </div>

            <button type="submit" class="btn btn-primary btn_submit">Save Changes</button>
            <div class="form-actions">
                <button type="submit" class="btn_second"><a href="crudadmin.php" class="btn btn-secondary btn_submit">Cancel</a></button>   
            </div>


        </form>
    </div>
    <script src="assets/js/helperFunctions.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>

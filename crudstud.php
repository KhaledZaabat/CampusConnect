<?php
session_start();

if ($_SESSION['user']['Role'] !== 'Admin'){
    die("just admins can access this page");
}
require 'headerAdmin.php';

//succeed
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']); // Remove the message after displaying it
}
// Fetch all students and their related details
$query = "SELECT s.Id, s.firstName, s.lastName, s.Email, s.phone, s.img_path, 
          b.blockName, f.FloorNumber, r.RoomNumber 
          FROM student s 
          LEFT JOIN room r ON s.roomId = r.Id
          LEFT JOIN floor f ON r.FloorID = f.Id
          LEFT JOIN block b ON f.BlockID = b.Id";
          
$result = $conn->query($query);

// Handle query error
if (!$result) {
    die("Error fetching students: " . $conn->error);
}
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>CRUD Student</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css"> <!-- Fonts -->
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/crud.css">
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            background: none;
        }
    </style>
</head>

<body>

    <div class="container2">
        <h1>Student Management</h1>
<?php

if (isset($_SESSION['error'])) {
    // Display the error message
    echo '<p style="color: red; font-weight: bold;">' . htmlspecialchars($_SESSION['error']) . '</p>';
    // Unset the session variable to prevent the message from showing again
    unset($_SESSION['error']);
}
?>
        <form action="addstud.php" method="post" class="student-form" id="student" enctype="multipart/form-data">
    <input type="text" placeholder="Student ID" name="StudentID" id="ID">
    <input type="text" placeholder="First Name" name="firstName">
    <input type="text" placeholder="Last Name" name="lastName">
    <input type="text" placeholder="Email" name="email">
    <input type="tel" placeholder="Phone Number" name="phone">
    
    <!-- Room and Floor Selection -->
    <div class="room-group">
        <select name="bloc">
            <option value="A" selected>Bloc A</option>
            <option value="B">Bloc B</option>
            <option value="C">Bloc C</option>
            <option value="D">Bloc D</option>
            <option value="E">Bloc E</option>
        </select>
        <select name="floor">
            <option value="0">R</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <input type="number" name="room" placeholder="Room Number" min="1" max="100">
    </div>            
    <div class="form-group mt-2">
        <label for="file" class="custom-file-upload">
            <div class="icon" id="upload-icon">
                <!-- Icon Content -->
            </div>
            <div class="text" id="upload-text">
                <span>Click to upload image</span>
            </div>
            <input id="file" type="file" name="image" accept="image/*" onchange="previewImage(event)">
        </label>
        <div id="image-preview" style="display: none; margin-top: 10px;">
            <img id="preview-img" src="" alt="Image Preview" style="max-width: 100px; max-height: 100px;">
            <p>Image uploaded!</p>
        </div>
    </div>
    <button type="submit" class="btn_submit" id="student">Add Student</button>
</form>
    </div>

    <div class="container3">
        <table>
            <h1>Students</h1>
            <div class="search-container">
                <button type="button" class="search-icon"><i class="fas fa-search"></i></button>
                <input type="text" class="search-bar" placeholder="Search by room number or last name">
            </div>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Room</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="student-table-body">
                <?php while ($student = $result->fetch_assoc()) : ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($student['img_path']); ?>" alt="Student Image" class="student-img"></td>
                    <td><input type="text" class="tableinput idinput" value="<?php echo htmlspecialchars($student['Id']); ?>" disabled></td>
                    <td><input type="text" class="tableinput name" value="<?php echo htmlspecialchars($student['firstName']); ?>" disabled></td>
                    <td><input type="text" class="tableinput name Lname" value="<?php echo htmlspecialchars($student['lastName']); ?>" disabled></td>
                    <td><input type="text" class="tableinput emailinput" value="<?php echo htmlspecialchars($student['Email']); ?>" disabled></td>
                    <td><input type="text" class="tableinput phone" value="<?php echo htmlspecialchars($student['phone']); ?>" disabled></td>
                    <td><input type="text" class="tableinput roominput" value="<?php echo htmlspecialchars($student['blockName']) . ' ' . htmlspecialchars($student['FloorNumber']) . ' ' . htmlspecialchars($student['RoomNumber']); ?>" disabled></td>
                    <td>
                        <div class="button-container">
                            <a href="editstud.php?userId=<?php echo htmlspecialchars($student['Id']); ?>" class="btn edit"><i class="fas fa-edit"></i></a>
                            <form action="deletestud.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                <input type="hidden" name="userId" value="<?php echo htmlspecialchars($student['Id']); ?>">
                                <button type="submit" id="deleteButton" class="delete"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <button id="prevpage" disabled><i class="fas fa-arrow-left"></i></button>
            <span id="page-num">1</span>
            <button id="nextpage"><i class="fas fa-arrow-right"></i></button>
        </div>
    </div>

    <div class="footer-spacing"></div>
    <?php include 'footer.php' ?>
</body>

<script src="assets/js/crud.js"></script>
<script src="assets/js/helperFunctions.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</html>

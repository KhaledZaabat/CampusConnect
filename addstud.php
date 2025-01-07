<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user']['Role'] !== 'Admin'){
    die(json_encode(['success' => false, 'message' => 'Only admins can access this page']));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capture and sanitize form inputs
    $studentID = htmlspecialchars(trim($_POST['StudentID'])) ?? null;
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $bloc = htmlspecialchars(trim($_POST['bloc']));
    $floor = (int) $_POST['floor'];
    $room = (int) $_POST['room'];
    $password = $firstName . " " . $lastName;
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // File upload validation
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        die(json_encode(['success' => false, 'message' => 'Error uploading image.']));
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        die(json_encode(['success' => false, 'message' => 'Invalid file type. Please upload an image.']));
    }

    $maxFileSize = 2 * 1024 * 1024; // 2MB
    if ($_FILES['image']['size'] > $maxFileSize) {
        die(json_encode(['success' => false, 'message' => 'File size exceeds the limit of 2MB.']));
    }

    // Directory to store uploaded images
    $uploadDir = 'uploads/profile_pics/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Generate unique file name and save image
    $fileName = $studentID . '_' . time() . '.' . $fileExtension;
    $filePath = $uploadDir . $fileName;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
        die(json_encode(['success' => false, 'message' => 'Error saving uploaded file.']));
    }

    // Check if room is already taken
    $roomCheckQuery = "SELECT s.Id FROM student s
                      JOIN room r ON s.roomId = r.Id
                      JOIN floor f ON r.FloorID = f.Id
                      JOIN block b ON f.BlockID = b.Id
                      WHERE b.blockName = ? AND f.FloorNumber = ? AND r.RoomNumber = ?";

    $roomCheckStmt = $conn->prepare($roomCheckQuery);
    $roomCheckStmt->bind_param("sss", $bloc, $floor, $room);
    $roomCheckStmt->execute();
    $roomCheckResult = $roomCheckStmt->get_result();
    $roomCheckStmt->close();

    if ($roomCheckResult->num_rows > 0) {
        // Store the error message in the session
        $_SESSION['error'] = 'Room is already occupied! Please select a different room.';
        // Redirect to 'crudstud.php'
        header('Location: crudstud.php');
        exit; // Stop further script execution
    }
    

    // Get room ID
    $roomQuery = "SELECT r.Id 
                  FROM room r
                  JOIN floor f ON r.FloorID = f.Id
                  JOIN block b ON f.BlockID = b.Id
                  WHERE b.blockName = ? AND f.FloorNumber = ? AND r.RoomNumber = ?";
    $stmt = $conn->prepare($roomQuery);
    $stmt->bind_param("sss", $bloc, $floor, $room);
    $stmt->execute();
    $result = $stmt->get_result();
    $roomData = $result->fetch_assoc();
    $stmt->close();

    if (!$roomData) {
        die(json_encode(['success' => false, 'message' => 'Room not found for the provided bloc, floor, and room number.']));
    }

    $roomId = $roomData['Id'];

    // Insert student data
    $insertQuery = "INSERT INTO student (Id, firstName, lastName, Email, Password, phone, roomId, img_path)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("ssssssis", $studentID, $firstName, $lastName, $email, $hashedPassword, $phone, $roomId, $filePath);

    if ($insertStmt->execute()) {
        // Store success message in session and redirect to 'crudstud.php'
        $_SESSION['success'] = 'Student added successfully!';
        header('Location: crudstud.php');
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding student: ' . $conn->error]);
    }

    $insertStmt->close();
    exit;
}
?>
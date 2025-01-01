<?php
require 'db_connection.php';

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
    $password = $firstName . " " . $lastName ;
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
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

    $maxFileSize = 2 * 1024 * 1024; // 2MB
    if ($_FILES['image']['size'] > $maxFileSize) {
        echo "<script>alert('File size exceeds the limit of 2MB.');</script>";
        exit;
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
        echo "<script>alert('Error saving uploaded file.');</script>";
        exit;
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

// If the room is taken, prevent insertion
if ($roomCheckResult->num_rows > 0) {
echo "<script>
 alert('Room is already occupied! Please select a different room.');
 window.location.href = 'addstud.php';
</script>";
exit; // Prevent further code execution
}

    // Retrieve room ID based on selected bloc, floor, and room
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
        echo "<script>alert('Room not found for the provided bloc, floor, and room number.');</script>";
        exit;
    }

    $roomId = $roomData['Id'];

    // Insert student data into database
    $insertQuery = "INSERT INTO student (Id, firstName, lastName, Email, Password, phone, roomId, img_path)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("ssssssis", $studentID, $firstName, $lastName, $email, $hashedPassword, $phone, $roomId, $filePath);

    if ($insertStmt->execute()) {
        echo "<script>
                alert('Student added successfully!');
                window.location.href = 'crudstud.php';
              </script>";
    } else {
        echo "<script>alert('Error adding student: " . $conn->error . "');</script>";
    }

    $insertStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Add Student</h1>
    <a href="crudstud.php" class="btn btn-secondary">Back to Student List</a>
</div>
</body>
</html>

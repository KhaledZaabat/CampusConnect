<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capture form inputs
    $studentID = $_POST['StudentID'] ?? null;
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $bloc = $_POST['bloc'];
    $floor = $_POST['floor'];
    $room = $_POST['room'];

    // Handle file upload
    $imagePath = "assets/img/default.jpg";
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imagePath = "assets/img/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
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

    if ($roomData) {
        $roomId = $roomData['Id'];

        // Insert into database
        $insertQuery = "INSERT INTO student (Id, firstName, lastName, Email, phone, roomId, img_path)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("sssssis", $studentID, $firstName, $lastName, $email, $phone, $roomId, $imagePath);

        if ($insertStmt->execute()) {
            echo "<script>
                    alert('Student added successfully!');
                    window.location.href = 'crudstud.php';
                  </script>";
        } else {
            echo "<script>alert('Error adding student: " . $conn->error . "');</script>";
        }

        $insertStmt->close();
    } else {
        echo "<script>alert('Room not found for the provided bloc, floor, and room number.');</script>";
    }
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

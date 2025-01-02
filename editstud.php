<?php
// Include database connection file
require 'db_connection.php';
session_start();

if ($_SESSION['user']['Role'] !== 'Admin'){
    die("just admins can access this page");
}
require 'headerAdmin.php';
// Ensure 'userId' parameter is passed via the URL for editing
if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];

    // Fetch existing student data
    $stmt = $conn->prepare("SELECT * FROM student WHERE Id = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();

    if (!$student) {
        echo "Student not found!";
        exit;
    }

    // Fetch blocks for the form
    $blocksQuery = "SELECT * FROM block";
    $blocksResult = $conn->query($blocksQuery);

    // Fetch floors
    $floorsQuery = "SELECT * FROM floor";
    $floorsResult = $conn->query($floorsQuery);

    // Fetch the selected student's room details
    $roomQuery = "SELECT r.Id, r.RoomNumber, f.FloorNumber, b.blockName
                  FROM room r 
                  JOIN floor f ON r.FloorID = f.Id
                  JOIN block b ON f.BlockID = b.Id
                  WHERE r.Id = ?";

    $roomStmt = $conn->prepare($roomQuery);
    $roomStmt->bind_param("i", $student['roomId']);
    $roomStmt->execute();
    $roomResult = $roomStmt->get_result();
    $roomData = $roomResult->fetch_assoc();
    $roomStmt->close();
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $bloc = $_POST['bloc'];
    $floor = $_POST['floor'];
    $room = $_POST['room'];

     // Check if the room is already taken
     $checkRoomQuery = "SELECT Id FROM student WHERE roomId = (SELECT r.Id FROM room r 
     JOIN floor f ON r.FloorID = f.Id
     JOIN block b ON f.BlockID = b.Id
     WHERE b.blockName = ? AND f.FloorNumber = ? AND r.RoomNumber = ?) 
     AND Id != ?";  // Exclude current student's ID to allow them to stay in their room
$checkRoomStmt = $conn->prepare($checkRoomQuery);
$checkRoomStmt->bind_param("ssss", $bloc, $floor, $room, $userId);
$checkRoomStmt->execute();
$roomResult = $checkRoomStmt->get_result();

if ($roomResult->num_rows > 0) {
// Room is already taken
echo "<script>
alert('Room already taken by another student!');
window.history.back();
</script>";
exit;
}

    // Process image upload
    if ($_FILES['image']['error'] === 0) {
        $imgPath = "assets/img/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imgPath);
    } else {
        $imgPath = $student['img_path'];
    }

    // Fetch the correct roomId based on the block, floor, and room number
    $roomQuery = "SELECT r.Id
                  FROM room r
                  JOIN floor f ON r.FloorID = f.Id
                  JOIN block b ON f.BlockID = b.Id
                  WHERE b.blockName = ? AND f.FloorNumber = ? AND r.RoomNumber = ?";
    $roomStmt = $conn->prepare($roomQuery);
    $roomStmt->bind_param("sss", $bloc, $floor, $room);
    $roomStmt->execute();
    $roomResult = $roomStmt->get_result();
    $roomData = $roomResult->fetch_assoc();
    $roomStmt->close();

    if ($roomData) {
        $roomId = $roomData['Id'];

        // Update the student information
        $updateStmt = $conn->prepare("UPDATE student SET firstName = ?, lastName = ?, Email = ?, phone = ?, roomId = ?, img_path = ? WHERE Id = ?");
        $updateStmt->bind_param("sssssss", $firstName, $lastName, $email, $phone, $roomId, $imgPath, $userId);

        if ($updateStmt->execute()) {
            echo "Student updated successfully!";
            header("Location: crudstud.php");
            exit;
        } else {
            echo "Error updating student.";
        }

        $updateStmt->close();
    } else {
        echo "Room not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/crud.css">
    <link rel="icon" href="assets/img/logo.png" type="image/png">
</head>
<body>
<div class="container2">
    <h1>Edit Student</h1>

    <!-- The form for editing the student -->
    <form action="" method="POST" class="student-form admin-form" enctype="multipart/form-data">
        <input type="text" id="userId" class="form-control" value="<?php echo htmlspecialchars($student['Id']); ?>" disabled>
        <input type="text" id="firstName" class="form-control" name="firstName" value="<?php echo htmlspecialchars($student['firstName']); ?>" required>
        <input type="text" id="lastName" class="form-control" name="lastName" value="<?php echo htmlspecialchars($student['lastName']); ?>" required>
        <input type="email" id="email" class="form-control" name="email" value="<?php echo htmlspecialchars($student['Email']); ?>" required>
        <input type="text" id="phone" class="form-control" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" required>

        <select id="bloc" class="form-control" name="bloc" required>
            <?php while ($block = $blocksResult->fetch_assoc()) : ?>
                <option value="<?php echo $block['blockName']; ?>" <?php if ($block['blockName'] == $roomData['blockName']) echo 'selected'; ?>>
                    <?php echo $block['blockName']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <select id="floor" class="form-control" name="floor" required>
            <?php while ($floor = $floorsResult->fetch_assoc()) : ?>
                <option value="<?php echo $floor['FloorNumber']; ?>" <?php if ($floor['FloorNumber'] == $roomData['FloorNumber']) echo 'selected'; ?>>
                    <?php echo $floor['FloorNumber']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="number" id="room" class="form-control" name="room" value="<?php echo htmlspecialchars($roomData['RoomNumber']); ?>" min="1" required>

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

            <?php if ($student['img_path']): ?>
                <div id="image-preview" style="display: block; margin-top: 10px;">
                    <img id="preview-img" src="<?php echo htmlspecialchars($student['img_path']); ?>" alt="Student Image" style="max-width: 100px; max-height: 100px;">
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
            <button type="submit" class="btn_second"><a href="crudstud.php" class="btn btn-secondary btn_submit">Cancel</a></button>
        </div>
    </form>
</div>
<script src="assets/js/helperFunctions.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>

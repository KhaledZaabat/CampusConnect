<?php 
session_start();
require 'headerStud.php'; // Assumes the database connection is established in this file

// Fetch available rooms
$sql = "SELECT r.Id, r.RoomNumber, f.FloorNumber, b.blockName
        FROM room r
        JOIN floor f ON r.FloorID = f.Id
        JOIN block b ON f.BlockID = b.Id
        LEFT JOIN student s ON r.Id = s.roomId
        WHERE s.roomId IS NULL";

$result = $conn->query($sql);

$rooms = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['userId'])) {
        $message = "User not authenticated";
    } else {
        try {
            // Get form data
            $userId = $_SESSION['userId'];
            $dormBlock = $_POST['dorm-block'];
            $floor = $_POST['floor'];
            $roomNumber = $_POST['room-number'];
            $reason = $_POST['reason'];
            $specialRequirements = $_POST['special-requirements'];

            // First, get the roomId based on the selected block, floor, and room number
            $stmt = $conn->prepare("
                SELECT r.Id 
                FROM room r
                INNER JOIN floor f ON r.FloorID = f.Id
                INNER JOIN block b ON f.BlockID = b.Id
                LEFT JOIN student s ON r.Id = s.roomId
                WHERE b.blockName = ? 
                AND f.FloorNumber = ? 
                AND r.RoomNumber = ? 
                AND s.roomId IS NULL
            ");

            if (!$stmt) {
                throw new Exception("Failed to prepare room query: " . $conn->error);
            }

            $stmt->bind_param("sii", $dormBlock, $floor, $roomNumber);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $message = "Selected room is not available or doesn't exist";
            } else {
                $room = $result->fetch_assoc();
                $roomId = $room['Id'];

                // Check if user already has a pending request
                $stmt = $conn->prepare("
                    SELECT id FROM roomrequest 
                    WHERE userId = ?
                ");
                $stmt->bind_param("s", $userId);
                $stmt->execute();

                if ($stmt->get_result()->num_rows > 0) {
                    $message = "You already have a pending room request";
                } else {
                    // Insert the room request
                    $stmt = $conn->prepare("
                        INSERT INTO roomrequest (userId, roomId, reason, description) 
                        VALUES (?, ?, ?, ?)
                    ");

                    if (!$stmt) {
                        throw new Exception("Failed to prepare insert query: " . $conn->error);
                    }

                    $stmt->bind_param("siss", $userId, $roomId, $reason, $specialRequirements);

                    if ($stmt->execute()) {
                        $message = "Room booking request submitted successfully!";
                    } else {
                        throw new Exception("Failed to submit booking request: " . $stmt->error);
                    }
                }
            }
        } catch (Exception $e) {
            $message = "An error occurred while processing your request: " . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Book Room</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Rooms.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="available-rooms">
        <h2>Available Rooms</h2>
        <input type="text" class="search-input form-control" id="search" placeholder="Search for rooms...">
        <table class="table">
            <thead>
                <tr>
                    <th data-column="block" class="sortable">Dorm Block <span class="sort-icon">⇅</span></th>
                    <th data-column="floor" class="sortable">Floor <span class="sort-icon">⇅</span></th>
                    <th data-column="number" class="sortable">Room Number <span class="sort-icon">⇅</span></th>
                </tr>
            </thead>
            <tbody id="room-table-body">
                <?php if (!empty($rooms)): ?>
                    <?php foreach ($rooms as $room): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($room['blockName']); ?></td>
                            <td><?php echo htmlspecialchars($room['FloorNumber']); ?></td>
                            <td><?php echo htmlspecialchars($room['RoomNumber']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No available rooms.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="Form-container">
        <h1>Book a Room</h1>
        <form action="index.php" method="post" id="book-room-form">
            <label for="dorm-block">Dorm Block Preference</label>
            <select id="dorm-block" name="dorm-block">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
            </select>

            <label for="floor">Floor</label>
            <select id="floor" name="floor">
                <option value="R">R</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

            <label for="room-number">Room Number</label>
            <input type="number" id="room-number" name="room-number" min="1" max="40">

            <label for="reason">Reason for Change (must be convenient)</label>
            <textarea id="reason" name="reason" rows="4"></textarea>

            <label class="checkbox">
                I confirm that the information provided is correct and understand that my request will be reviewed.
                <input type="checkbox" name="confirm" id="confirm-checkbox">
            </label>

            <button class="submit" type="submit">Submit</button>
        </form>
    </div>

    <script src="assets/js/Rooms.js"></script>
    <?php include 'footer.php' ?>
</body>
</html>

<?php 
session_start();
require 'headerStud.php';

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

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['room-submit'])) {
    if (!isset($_SESSION['user']['Id'])) {
        $message = "User not authenticated";
    } else {
        error_log("POST data: " . print_r($_POST, true));
        // Validate required fields
        if (empty($_POST['dorm-block']) || 
            $_POST['floor'] === "" || 
            empty($_POST['room-number']) || 
            empty($_POST['reason']) || 
            empty($_POST['type'])) {
            
        
            $message = "All fields are required";
    } else {
            $userId = $_SESSION['user']['Id'];
            $dormBlock = $_POST['dorm-block'];
            $floor = $_POST['floor'];
            $roomNumber = $_POST['room-number'];
            $reason = $_POST['reason'];
            $specialRequirements = $_POST['special-requirements'] ?? '';
            $type = $_POST['type'];

            // Begin transaction
            $conn->begin_transaction();

            try {
                // Check for pending requests
                $checkStmt = $conn->prepare("SELECT userId FROM roomrequest WHERE userId = ? AND description IS NULL");
                $checkStmt->bind_param("s", $userId); // 's' is for string (varchar type for userId)
                $checkStmt->execute();
                
                if ($checkStmt->get_result()->num_rows > 0) {
                    throw new Exception("You already have a pending room request");
                }

                error_log("User ID: " . $userId);
                error_log("Dorm Block: " . $dormBlock);
                error_log("Floor: " . $floor);
                error_log("Room Number: " . $roomNumber);

                // Get room ID
                $roomStmt = $conn->prepare("
                    SELECT r.Id 
                    FROM room r
                    INNER JOIN floor f ON r.FloorID = f.Id
                    INNER JOIN block b ON f.BlockID = b.Id
                    WHERE b.blockName = ? 
                    AND f.FloorNumber = ? 
                    AND r.RoomNumber = ? 
                    AND NOT EXISTS (
                        SELECT 1 FROM student s WHERE s.roomId = r.Id
                    )");
                
                $roomStmt->bind_param("sii", $dormBlock, $floor, $roomNumber);
                $roomStmt->execute();
                $roomResult = $roomStmt->get_result();

                if ($roomResult->num_rows === 0) {
                    throw new Exception("Selected room is not available");
                }

                $roomId = $roomResult->fetch_assoc()['Id'];

                // Insert request
                $insertStmt = $conn->prepare("
                    INSERT INTO roomrequest (userId, roomId, reason, description, type) 
                    VALUES (?, ?, ?, ?, ?)");
                
                    $specialRequirements = $specialRequirements ?? '';
                    $insertStmt->bind_param("sisss", $userId, $roomId, $reason, $specialRequirements, $type);
                    try {
                        // SQL logic...
                        $insertStmt->execute();
                        if ($insertStmt->affected_rows === 0) {
                            throw new Exception("No rows inserted. Insert statement failed.");
                        }
                        $conn->commit();
                        $message = "Room booking request submitted successfully!";
                    } catch (Exception $e) {
                        $conn->rollback();
                        error_log($e->getMessage()); // Logs to the server's error log
                        $message = "Error: " . $e->getMessage();
                    }    
            } catch (Exception $e) {
                $conn->rollback();
                $message = $e->getMessage();
            }
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
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/Rooms.css">
</head>
<body>
    <?php if ($message): ?>
        <div class="alert <?php echo strpos($message, 'success') !== false ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <div class="available-rooms">
        <h2>Available Rooms</h2>
        <input type="text" class="search-input form-control" id="search" placeholder="Search for rooms...">
        <table class="Table">
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
        <div class="pagination">
        <button id="prev" disabled><i class="fas fa-arrow-left"></i></button>
        <span id="page-num">1</span>
        <button id="next"><i class="fas fa-arrow-right"></i></button>
    </div>
</div>

    </div>

    <div class="Form-container">
        <h1>Book a Room</h1>
        <form method="post" id="book-room-form">
            <label for="type">Type</label>
            <select id="type" name="type" required>
                <option value="book">Book</option>
                <option value="change">Change</option>
            </select>
            <label for="dorm-block">Dorm Block Preference</label>
            <select id="dorm-block" name="dorm-block" required>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
            </select>

            <label for="floor">Floor</label>
            <select id="floor" name="floor" required>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

            <label for="room-number">Room Number</label>
            <input type="number" id="room-number" name="room-number" min="1" max="40" required>

            <label for="reason">Reason</label>
            <textarea id="reason" name="reason" rows="4" required></textarea>
            <div id="reason-error" class="error-message" style="display: none;"></div>


            <label for="special-requirements">Special Requirements</label>
            <textarea id="special-requirements" name="special-requirements" rows="4"></textarea>

            <label class="checkbox">
                <input type="checkbox" name="confirm" id="confirm-checkbox" required>
                    I confirm that the information provided is correct
            </label>
            <div id="checkbox-error" class="error-message" style="display: none;"></div>

            <button class="submit" type="submit" name="room-submit">Submit</button>
            </form>
    </div>
    <script src="assets/js/Rooms.js"></script>
    <?php include 'footer.php' ?>
</body>
</html>

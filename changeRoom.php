<?php 
    session_start();
    require 'headerStud.php'; // Assumes the database connection is established in this file

    // Fetch available rooms
    $sql = "SELECT r.Id, r.RoomNumber, f.FloorNumber, b.blockName
FROM room r
JOIN floor f ON r.FloorID = f.Id
JOIN block b ON f.BlockID = b.Id
LEFT JOIN student s ON r.Id = s.roomId
WHERE s.roomId IS NULL;
";

    $result = $conn->query($sql);

    $rooms = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }
    }
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Book Room</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/css/Rooms.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Rooms.js"></script>

    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
</head>

<body>
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
        <div class="pagination">
            <button id="prev" disabled><i class="fas fa-arrow-left"></i></button>
            <span id="page-num">1</span>
            <button id="next"><i class="fas fa-arrow-right"></i></button>
        </div>
    </div>


    <div class="Form-container">
        <h1>Change Room Request Form</h1>
        <form action="#" method="post" >

            <!-- New Room Preferences -->
            <label for="dorm-block">Dorm Block Preference</label>
            <select id="dorm-block" name="dorm-block">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
            </select>

            <!-- Floor Selection -->
            <label for="floor">Floor</label>
            <select id="floor" name="floor">
                <option value="R">R</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

            <!-- Room Number -->
            <label for="room-number">Room Number</label>
            <input type="number" id="room-number" name="room-number" min="1" max="40">
            <div id="room-number-error" class="error-message">You must fill in this field.</div>

            <!-- Reason for Change -->
            <label for="reason">Reason for Change (must be convenient)</label>
<textarea id="reason" name="reason" rows="4"></textarea>
<div id="reason-error" class="error-message">You must provide a reason for the change.</div>


            <!-- Confirmation -->
                <label class="checkbox">
                    I confirm that the information provided is correct and understand that my request will be reviewed.
                    <input type="checkbox" name="confirm" id="confirm-checkbox">
                </label>
                <div id="checkbox-error" class="error-message">You must confirm that the information provided is correct.</div>

            <!-- Submit Button -->
            <button class="submit" type="submit">Submit</button>
        </form>
    </div>
    <?php include 'footer.php' ?>
</body>








</html>
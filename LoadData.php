<?php
session_start();
require 'db_connection.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the action parameter is set
    if (isset($_POST['action']) && $_POST['action'] === 'fetch') {
        $query = "
            SELECT 
                rr.id,
                CONCAT(s.firstName, ' ', s.lastName) AS studentName,
                CONCAT(cb.blockName, cf.FloorNumber, cr.RoomNumber) AS currentRoom,
                CONCAT(rb.blockName, rf.FloorNumber, r.RoomNumber) AS requestedRoom,
                rr.reason,
                rr.description,
                rr.status,
                rr.type
            FROM 
                roomrequest rr
            JOIN student s ON rr.userId = s.Id
            JOIN room cr ON s.roomId = cr.Id
            JOIN floor cf ON cr.FloorID = cf.Id
            JOIN block cb ON cf.blockId = cb.Id
            JOIN room r ON rr.roomId = r.Id
            JOIN floor rf ON r.FloorID = rf.Id
            JOIN block rb ON rf.blockId = rb.Id
            ORDER BY rr.status ASC, currentRoom DESC";

        // Debugging: Log the query
        error_log("Executing query: " . $query);

        $result = $conn->query($query);

        // Debugging: Check if the query was successful
        if (!$result) {
            error_log("Query failed: " . $conn->error);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Query failed']);

            exit;

        }

        $requests = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $requests[] = $row;
            }
        } else {
            error_log("No rows found in the query result.");
        }

        $conn->close();

        // Debugging: Log the fetched data
        error_log("Fetched data: " . print_r($requests, true));

        // Output JSON data
        header('Content-Type: application/json');
        echo json_encode($requests);
        exit;
    } else {
        // Invalid action
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid action']);
        exit;
    }
} else {
    // Invalid request method
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}
?>
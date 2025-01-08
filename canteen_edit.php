<?php
// canteen_edit.php
header('Content-Type: application/json');
require 'db_connection.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Log incoming data
$raw_data = file_get_contents('php://input');
error_log("Received data: " . $raw_data);

$data = json_decode($raw_data, true);

// Check if the necessary data is received
if (!isset($data['changes'])) {
    echo json_encode(['success' => false, 'message' => 'No changes data received']);
    exit;
}

$success = true;
$updates = [];

// Loop through each change and update the record in the database
foreach ($data['changes'] as $change) {
    // Log each change
    error_log("Processing change: " . json_encode($change));
    
    if (!isset($change['id'], $change['value'], $change['type'])) {
        error_log("Missing required fields in change");
        $success = false;
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    // Validate the type field
    if (!in_array($change['type'], ['amount', 'meal'])) {
        error_log("Invalid type: " . $change['type']);
        echo json_encode(['success' => false, 'message' => 'Invalid type specified: ' . $change['type']]);
        exit;
    }

    $id = (int) $change['id'];
    $value = $change['value'];
    $field = $change['type'];

    // Create the SQL query using mysqli's real_escape_string for the field name
    // since prepared statements don't work with column names
    $field = mysqli_real_escape_string($conn, $field);
    
    // Log the query we're about to execute
    $query = "UPDATE meals SET `$field` = ? WHERE id = ?";
    error_log("Executing query: " . $query . " with values: " . $value . ", " . $id);

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("si", $value, $id);
    
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        echo json_encode(['success' => false, 'message' => 'Execute failed: ' . $stmt->error]);
        exit;
    }

    $updates[] = [
        'id' => $id,
        'field' => $field,
        'value' => $value,
        'affected_rows' => $stmt->affected_rows
    ];
    
    $stmt->close();
}

// Return detailed response
echo json_encode([
    'success' => $success,
    'updates' => $updates
]);
?>
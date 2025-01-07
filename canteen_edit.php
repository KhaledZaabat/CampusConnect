<?php
// canteen_edit.php
header('Content-Type: application/json');
require 'db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);

// Check if the necessary data is received
if (!isset($data['changes'])) {
    echo json_encode(['success' => false, 'message' => 'No changes data received']);
    exit;
}

$success = true;

// Loop through each change and update the record in the database
foreach ($data['changes'] as $change) {
    if (!isset($change['id'], $change['value'], $change['type'])) {
        $success = false;
        break;
    }

    // Sanitize and escape input data
    $id = (int) mysqli_real_escape_string($conn, $change['id']);
    $value = mysqli_real_escape_string($conn, $change['value']);
    $field = ($change['type'] === 'amount') ? 'amount' : 'meal';

    // Prepare the update query
    $query = "UPDATE meals SET $field = '$value' WHERE id = $id";
    
    // Execute the query
    if (!mysqli_query($conn, $query)) {
        $success = false;
        echo json_encode(['success' => $success, 'message' => mysqli_error($conn)]);
        exit; 
    }
}

echo json_encode(['success' => $success]);
?>

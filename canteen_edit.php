<?php
// update_meals.php
header('Content-Type: application/json');
require_once 'db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);
$success = true;

foreach ($data['changes'] as $change) {
    $id = mysqli_real_escape_string($conn, $change['id']);
    $value = mysqli_real_escape_string($conn, $change['value']);
    $field = $change['type'] === 'amount' ? 'amount' : 'meal';
    
    $query = "UPDATE meals SET $field = '$value' WHERE id = $id";
    if (!mysqli_query($conn, $query)) {
        $success = false;
        break;
    }
}

echo json_encode(['success' => $success]);
?>
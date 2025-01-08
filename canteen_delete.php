<?php
// canteen_delete.php
header('Content-Type: application/json');
require 'db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);

// Ensure that the ID is provided
if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'No meal ID provided']);
    exit;
}

$id = (int) mysqli_real_escape_string($conn, $data['id']);

// Prepare and execute the delete query
$query = "DELETE FROM meals WHERE id = $id";
$success = mysqli_query($conn, $query);

echo json_encode(['success' => $success]);
?>

<?php 

// delete_meal.php
header('Content-Type: application/json');
require_once 'db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = mysqli_real_escape_string($conn, $data['id']);

$query = "DELETE FROM meals WHERE id = $id";
$success = mysqli_query($conn, $query);

echo json_encode(['success' => $success]);
?>
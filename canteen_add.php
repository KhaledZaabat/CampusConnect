<?php

// add_meal.php
header('Content-Type: application/json');
require 'db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);
$dayId = mysqli_real_escape_string($conn, $data['dayId']);
$typeId = mysqli_real_escape_string($conn, $data['typeId']);

$query = "INSERT INTO meals (meal, amount, dayid, typeid) VALUES ('New Item', 'Amount', $dayId, $typeId)";
$success = mysqli_query($conn, $query);
$mealId = $success ? mysqli_insert_id($conn) : null;

echo json_encode(['success' => $success, 'mealId' => $mealId]);

// delete_meal.php
header('Content-Type: application/json');
require_once 'db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = mysqli_real_escape_string($conn, $data['id']);

$query = "DELETE FROM meals WHERE id = $id";
$success = mysqli_query($conn, $query);

echo json_encode(['success' => $success]);

?>
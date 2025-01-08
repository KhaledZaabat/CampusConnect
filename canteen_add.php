<?php
// canteen_add.php
header('Content-Type: application/json');
require 'db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);

// Validate inputs to prevent malicious data
if (!isset($data['dayId'], $data['typeId'], $data['meal'], $data['amount'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
    exit;
}

$dayId = (int) mysqli_real_escape_string($conn, $data['dayId']);
$typeId = (int) mysqli_real_escape_string($conn, $data['typeId']);
$meal = mysqli_real_escape_string($conn, $data['meal']);
$amount = mysqli_real_escape_string($conn, $data['amount']);

// Insert query to add a new meal
$query = "INSERT INTO meals (meal, amount, dayid, typeid) VALUES ('$meal', '$amount', $dayId, $typeId)";
$success = mysqli_query($conn, $query);

// Get the ID of the inserted meal
$mealId = $success ? mysqli_insert_id($conn) : null;

echo json_encode(['success' => $success, 'mealId' => $mealId]);
?>

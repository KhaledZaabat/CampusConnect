<?php
// Include database connection
include 'db_connection.php';

// Check if user ID is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
    $userId = intval($_POST['userId']); // Sanitize input

    // Debugging: Log user ID
    error_log("Deleting user with ID: " . $userId);

    // Prepare and execute DELETE SQL query
    $stmt = $conn->prepare("DELETE FROM employee WHERE Id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        // Redirect with success message
        header('Location: crudadmin.php?message=success');
        exit;
    } else {
        // Redirect with error message
        error_log("Error deleting user: " . $stmt->error);
        header('Location: crudadmin.php?message=error');
        exit;
    }
} else {
    // Invalid request
    header('Location: crudadmin.php?message=invalid');
    exit;
}
?>

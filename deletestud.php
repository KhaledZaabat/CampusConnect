<?php
// Include database connection file
require 'db_connection.php';

// Ensure 'userId' parameter is passed via the form for deleting
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Prepare and execute the delete query for the student
    $deleteStmt = $conn->prepare("DELETE FROM student WHERE Id = ?");
    $deleteStmt->bind_param("s", $userId);

    if ($deleteStmt->execute()) {
        // Redirect to the main student management page after deletion
        header("Location: crudstud.php");
        exit;
    } else {
        echo "Error deleting student.";
    }

    $deleteStmt->close();
} else {
    echo "Student ID not provided!";
}
?>

<?php
include 'db_connection.php'; // Include the database connection file

// Ensure it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $response = [];

    // Get the raw POST data
    $rawPostData = file_get_contents("php://input");
    $postData = json_decode($rawPostData, true);

    if (isset($postData['action'])) {
        $action = $postData['action'];

        if ($action === 'update' && isset($postData['Id'], $postData['Title'], $postData['Content'])) {
            $id = $postData['Id'];
            $title = $postData['Title'];
            $content = $postData['Content'];

            // Prepare and execute the update query
            $stmt = $conn->prepare('UPDATE lostandfoundpost SET Title = ?, Content = ? WHERE Id = ?');
            $stmt->bind_param('ssi', $title, $content, $id);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Post updated successfully';
            } else {
                $response['success'] = false;
                $response['message'] = 'Failed to update post';
            }

            $stmt->close();
        } elseif ($action === 'delete' && isset($postData['Id'])) {
            $id = $postData['Id'];

            // Prepare and execute the delete query
            $stmt = $conn->prepare('DELETE FROM lostandfoundpost WHERE Id = ?');
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Post deleted successfully';
            } else {
                $response['success'] = false;
                $response['message'] = 'Failed to delete post';
            }

            $stmt->close();
        } else {
            $response['success'] = false;
            $response['message'] = 'Invalid data';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid data';
    }

    echo json_encode($response);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

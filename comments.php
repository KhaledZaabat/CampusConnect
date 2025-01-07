<?php
include 'db_connection.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['action']) && $data['action'] === 'edit') {
        $commentId = $data['commentId'];
        $content = $data['content'];

        if ($commentId && $content) {
            $stmt = $conn->prepare('UPDATE comment SET Content = ? WHERE Id = ?');
            $stmt->bind_param('si', $content, $commentId);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update comment.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
        }
    }
    elseif (isset($data['action']) && $data['action'] === 'create') {
        $postId = $data['postId'];
        $content = $data['content'];
        $userId = $data['userId'];
    
        if ($postId && $content && $userId) {
            $stmt = $conn->prepare('INSERT INTO comment (PostId, Content, UserId, Datetime) VALUES (?, ?, ?, NOW())');
            $stmt->bind_param('isi', $postId, $content, $userId);
    
            if ($stmt->execute()) {
                $commentId = $conn->insert_id;
    
                // Initialize the variable to store the firstName
                $FirstName = null;
    
                // First query: Check in the student table
                $stmt = $conn->prepare('SELECT firstName FROM student WHERE Id = ?');
                $stmt->bind_param('s', $userId);
                $stmt->execute();
                $stmt->bind_result($FirstName);
    
                if (!$stmt->fetch()) {
                    // If no result found in the student table, check the employee table
                    $stmt->close();
                    $stmt = $conn->prepare('SELECT firstName FROM employee WHERE Id = ?');
                    $stmt->bind_param('s', $userId);
                    $stmt->execute();
                    $stmt->bind_result($FirstName);
                    $stmt->fetch();
                }
    
                $stmt->close(); // Close the statement
    
                if ($FirstName) {
                    echo json_encode(['success' => true, 'username' => $FirstName, 'Id' => $commentId]);
                } else {
                    echo json_encode(['success' => true, 'username' => null, 'Id' => $commentId]);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create comment.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
        }
    }    
    
    elseif (isset($data['action']) && $data['action'] === 'delete') {
        $commentId = $data['commentId'];
        $userId = $data['userId'];

        if ($commentId && $userId) {
            $stmt = $conn->prepare('DELETE FROM comment WHERE Id = ? AND UserId = ?');
            $stmt->bind_param('ii', $commentId, $userId);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete comment.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
        }
    }
    else {
        echo json_encode(['success' => false, 'message' => 'Invalid action provided.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

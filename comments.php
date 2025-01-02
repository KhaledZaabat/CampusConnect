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
                // Fetch the username (either student or employee)
                $stmt = $conn->prepare('
                    SELECT COALESCE(s.FirstName, e.FirstName) as FirstName
                    FROM student s
                    LEFT JOIN employee e ON s.Id = e.Id
                    WHERE s.Id = ? OR e.Id = ?
                ');
                $stmt->bind_param('ii', $userId, $userId);
                $stmt->execute();
                $stmt->bind_result($username);
                $stmt->fetch();

                echo json_encode(['success' => true, 'username' => $username]);
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
            // Check if the user has permission to delete the comment
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

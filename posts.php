<?php
include 'db_connection.php';
session_start();

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    header('Content-Type: application/json');
    try {
        $sql = '
            SELECT 
                p.*,
                DATE_FORMAT(p.Datetime, "%Y-%m-%d %H:%i") as formatted_datetime,
                COALESCE(s.FirstName, e.FirstName) as FirstName,
                c.Id as CommentId,
                c.Content as CommentContent,
                c.UserId as CommentUserId,
                DATE_FORMAT(c.Datetime, "%Y-%m-%d %H:%i") as CommentDatetime,
                COALESCE(cs.FirstName, ce.FirstName) as CommentFirstName
            FROM 
                lostandfoundpost p
            LEFT JOIN 
                student s ON p.UserId = s.Id
            LEFT JOIN 
                employee e ON p.UserId = e.Id
            LEFT JOIN 
                comment c ON p.Id = c.PostId
            LEFT JOIN 
                student cs ON c.UserId = cs.Id
            LEFT JOIN 
                employee ce ON c.UserId = ce.Id
            ORDER BY 
                p.DateTime DESC, c.Datetime ASC
        ';
        $stmt = $conn->query($sql);
        $posts = $stmt->fetch_all(MYSQLI_ASSOC);

        $result = [];
        foreach ($posts as $post) {
            if (!isset($result[$post['Id']])) {
                $result[$post['Id']] = $post;
                $result[$post['Id']]['comment'] = [];
                if (!empty($post['img'])) {
                    $result[$post['Id']]['img'] = base64_encode($post['img']);
                }
                unset($result[$post['Id']]['Datetime']);
                $result[$post['Id']]['Datetime'] = $result[$post['Id']]['formatted_datetime'];
                unset($result[$post['Id']]['formatted_datetime']);
            }

            if (!empty($post['CommentId'])) {
                $result[$post['Id']]['comment'][] = [
                    'Id' => $post['CommentId'],
                    'Content' => $post['CommentContent'],
                    'UserId' => $post['CommentUserId'],
                    'Datetime' => $post['CommentDatetime'],
                    'FirstName' => $post['CommentFirstName']
                ];
            }
        }

        echo json_encode(array_values($result));
    } catch (Exception $e) {
        echo json_encode(['error' => 'Failed to fetch posts: ' . $e->getMessage()]);
    }
}


elseif ($method === 'POST') {
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // temporary storing uploaded images
        $uploadDir = 'uploads/'; 
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
    
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $imagePath = realpath($uploadFile);
    
            if ($imagePath && file_exists($imagePath)) {
                $title = htmlspecialchars($_POST['title']);
                $description = htmlspecialchars($_POST['description']);
                $type = htmlspecialchars($_POST['listingType']);
                $userId = $_SESSION['user']['Id'];
                $datetime = date("Y-m-d H:i:s");
                if (strlen($title) > 100) {
                    echo "Title must be less than 100 characters.";
                    exit;
                }
                
                if (strlen($description) > 300) {
                    echo "Description must be less than 300 characters.";
                    exit;
                }
                $sql = "INSERT INTO lostandfoundpost (Title, Content, UserId, Datetime, Type, img)
                        VALUES (?, ?, ?, ?, ?, LOAD_FILE(?))";
    
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $title, $description, $userId, $datetime, $type, $imagePath);
    
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'id' => $conn->insert_id]);
                } else {
                    echo json_encode(['error' => 'Failed to save post: ' . $stmt->error]);
                }
                unlink($imagePath);

            } else {
                echo json_encode(['error' => 'File does not exist or is not accessible.']);
            }
        } else {
            echo json_encode(['error' => 'Failed to move uploaded image.']);
        }
    } else {
        echo json_encode(['error' => 'Image upload failed: ' . $_FILES['image']['error']]);
    }
}
$conn->close();
?>

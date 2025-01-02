<?php
include 'db_connection.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    header('Content-Type: application/json');
    try {
        $sql = '
            SELECT 
                p.*, 
                DATE_FORMAT(p.Datetime, "%Y-%m-%d %H:%i") as formatted_datetime,
                COALESCE(s.FirstName, e.FirstName) as FirstName
            FROM 
                lostandfoundpost p
            LEFT JOIN 
                student s ON p.UserId = s.Id
            LEFT JOIN 
                employee e ON p.UserId = e.Id
            ORDER BY p.DateTime DESC;
        ';
        $stmt = $conn->query($sql);
        $posts = $stmt->fetch_all(MYSQLI_ASSOC);

        foreach ($posts as &$post) {
            if (!empty($post['img'])) {
                $post['img'] = base64_encode($post['img']);
            }
            unset($post['Datetime']);
            $post['Datetime'] = $post['formatted_datetime'];
            unset($post['formatted_datetime']);
        }

        echo json_encode($posts);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Failed to fetch posts: ' . $e->getMessage()]);
    }
}


elseif ($method === 'POST') {
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Define the temporary directory for storing uploaded images
        $uploadDir = 'uploads/'; // Ensure this directory is writable by the server
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
    
        // Move the uploaded file to the temporary directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // Get the absolute file path of the uploaded image
            $imagePath = realpath($uploadFile);
    
            // Ensure the file exists and is accessible
            if ($imagePath && file_exists($imagePath)) {
                $title = htmlspecialchars($_POST['title']);
                $description = htmlspecialchars($_POST['description']);
                $type = htmlspecialchars($_POST['listingType']);
                $userId = $_SESSION['user']['Id'];
                $datetime = date("Y-m-d H:i:s");
    
                // Use LOAD_FILE to insert the image from the server's file system
                $sql = "INSERT INTO lostandfoundpost (Title, Content, UserId, Datetime, Type, img)
                        VALUES (?, ?, ?, ?, ?, LOAD_FILE(?))";
    
                // Prepare and bind parameters
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $title, $description, $userId, $datetime, $type, $imagePath);
    
                // Execute the statement
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'id' => $conn->insert_id]);
                } else {
                    echo json_encode(['error' => 'Failed to save post: ' . $stmt->error]);
                }
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

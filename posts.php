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
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data['title'], $data['description'], $data['image'], $data['type'])) {
        $title = htmlspecialchars($data['title']);
        $description = htmlspecialchars($data['description']);
        $image = htmlspecialchars($data['image']);
        $type = htmlspecialchars($data['type']);
        $comments = isset($data['comments']) ? json_encode($data['comments']) : json_encode([]);

        try {
            $stmt = $pdo->prepare("INSERT INTO posts (title, description, image, type, comments) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $image, $type, $comments]);

            echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to save post: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid data. Ensure title, description, image, and type are provided.']);
    }
}

else {
    echo json_encode(['error' => 'Unsupported request method']);
}
?>

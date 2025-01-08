<?php
session_start();
if ($_SESSION['user']['Role'] !== 'Admin'){
    die("just admins can access this page");
}
require 'db_connection.php';
$response = [
    'message' => '',
    'errors' => []
];

// Initialize variables
$isEdit = false;
$title = '';
$content = '';
$currentFile = '';

// Check if we're in edit mode
if (isset($_GET['id'])) {
    $isEdit = true;
    $stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $newsData = $result->fetch_assoc();
    $stmt->close();

    if ($newsData) {
        $title = $newsData['title'];
        $content = $newsData['content'];
        $currentFile = $newsData['FILE'];
    } else {
        die("News article not found");
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['news-title']);
    $content = $_POST['news-content-input'];
    $date = date("Y-m-d H:i:s");
    $filePath = $currentFile; // Keep existing file path by default

    // Validate inputs
    if (empty(trim($title))) {
        $response['errors'][] = 'Title is required';
    }
    if (empty(trim($content)) || $content == 'Type your content here...') {
        $content = '';
        $response['errors'][] = 'Content is required';
    }

    // Handle file upload if exists
    if (isset($_FILES['news-file']) && $_FILES['news-file']['error'] === 0) {
        $fileTmpPath = $_FILES['news-file']['tmp_name'];
        $fileName = $_FILES['news-file']['name'];
        $fileSize = $_FILES['news-file']['size'];
        $fileType = $_FILES['news-file']['type'];

        // Only allow PDF files
        $allowedFileTypes = ['application/pdf'];

        if (!in_array($fileType, $allowedFileTypes)) {
            $response['errors'][] = 'Only PDF files are allowed';
        } else {
            $uploadDir = 'uploads/';

            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    $response['errors'][] = 'Failed to create upload directory';
                }
            }

            if (!is_writable($uploadDir)) {
                $response['errors'][] = 'Upload directory is not writable';
            } else {
                $filePath = $uploadDir . basename($fileName);

                // If editing and there's an existing file, delete it
                if ($isEdit && !empty($currentFile) && file_exists($currentFile)) {
                    unlink($currentFile);
                }

                if (!move_uploaded_file($fileTmpPath, $filePath)) {
                    $response['errors'][] = 'There was an error uploading the file';
                }
            }
        }
    }

    if (empty($response['errors'])) {
        if ($isEdit) {
            // Update existing news
            $stmt = $conn->prepare("UPDATE news SET title = ?, content = ?, file = ?, Date = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $title, $content, $filePath, $date, $_GET['id']);
        } else {
            // Insert new news
            $stmt = $conn->prepare("INSERT INTO news (Date, title, content, file) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $date, $title, $content, $filePath);
        }

        if ($stmt->execute()) {
            $response['message'] = $isEdit ? 'News article updated successfully' : 'News article published successfully';
        } else {
            $response['errors'][] = 'An error occurred while executing the command';
        }
        $stmt->close();
    }
    // Return JSON response for AJAX requests
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $isEdit ? 'Edit' : 'Add'; ?> News</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/AddNews.css">
    <script src="assets/js/AddNew.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
</head>
<?php
require 'headerAdmin.php';
?>
<body>
    <div class="form-new">
        <div class="news-form-container">
            <h1><?php echo $isEdit ? 'Edit' : 'Add'; ?> News</h1>
            <form id="news-form" action="" method="POST" enctype="multipart/form-data">
                <div id="response"></div>
                
                <label for="news-title">News Title</label>
                <input type="text" id="news-title" name="news-title" placeholder="Enter news title" 
                       value="<?php echo htmlspecialchars($title); ?>">
                
                <div class="text-editor-toolbar">
                    <button type="button" id="add-table-btn" title="Add table"><i class="fas fa-table"></i> Add table</button>
                    <button type="button" data-command="bold" title="Bold"><i class="fas fa-bold"></i></button>
                    <button type="button" data-command="italic" title="Italic"><i class="fas fa-italic"></i></button>
                    <button type="button" data-command="underline" title="Underline"><i class="fas fa-underline"></i></button>
                    <button type="button" id="add-link-btn" title="Add link"><i class="fas fa-link"></i></button>
                    <button type="button" id="color-btn" title="Change text color"><i class="fas fa-palette"></i></button>
                    <input type="color" id="color-picker" style="display: none;">
                </div>
                
                <div id="news-content" contenteditable="true" name="news-content" 
                     style="border: 1px solid #ccc; padding: 10px; border-radius: 4px; min-height: 200px;">
                    <?php echo $content; ?>
                </div>
                <input type="hidden" name="news-content-input" id="hidden-content">

                <div id="linkModal" class="modal">
                    <div class="modal-content">
                        <span class="close" id="linkModalClose">&times;</span>
                        <label for="linkUrl">Enter URL:</label>
                        <input type="text" id="linkUrl" name="linkUrl" placeholder="http://">
                        <button type="button" id="linkSubmit">Add Link</button>
                    </div>
                </div>

                <div id="tableModal" class="modal">
                    <div class="modal-content">
                        <span class="close" id="tableModalClose">&times;</span>
                        <label for="tableRows">Rows:</label>
                        <input type="number" id="tableRows" name="tableRows" min="1" value="2">
                        <label for="tableCols">Columns:</label>
                        <input type="number" id="tableCols" name="tableCols" min="1" value="2">
                        <button type="button" id="tableSubmit">Insert Table</button>
                    </div>
                </div>

                <!-- File upload section -->
                <label for="news-file">Upload PDF</label>
                <?php if ($isEdit && !empty($currentFile)): ?>
                    <p>Current file: <?php echo basename($currentFile); ?></p>
                <?php endif; ?>
                <input type="file" id="news-file" name="news-file" accept="application/pdf">

                <div id="colorModal" class="modal">
                    <div class="modal-content">
                        <span class="close" id="colorModalClose">&times;</span>
                        <label for="colorPicker">Choose Color:</label>
                        <input type="color" id="colorPicker">
                        <button id="colorSubmit">Apply Color</button>
                    </div>
                </div>

                <div class="buttons-container">
                    <button type="submit" class="submit btn-publish">
                        <?php echo $isEdit ? 'Update' : 'Publish'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php include 'footer.php' ?>

    <script>
        document.getElementById("news-form").addEventListener("submit", function (event) {
            event.preventDefault();

            // Don't save placeholder text
            const newsContent = document.getElementById("news-content");
            const contentValue = newsContent.innerHTML.trim();
            if (contentValue === '' || contentValue === 'Type your content here...') {
                newsContent.innerHTML = '';
            }
            document.getElementById("hidden-content").value = contentValue;

            const formData = new FormData(this);
            const responseMessage = document.getElementById("response");
            responseMessage.innerHTML = "";

            fetch("", {
                method: "POST",
                body: formData
            })
            .then(response => {
                console.log(response); // Check the response status
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();})
            .then(data => {
                if (data.errors && data.errors.length > 0) {
                    data.errors.forEach(error => {
                        const errorDiv = document.createElement('div');
                        errorDiv.classList.add('alert', 'alert-danger');
                        errorDiv.textContent = error;
                        responseMessage.appendChild(errorDiv);
                    });
                } else if (data.message) {
                    responseMessage.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    if (!<?php echo $isEdit ? 'true' : 'false' ?>) {
                        // Clear form for new submissions
                        this.reset();
                        newsContent.innerHTML = '';
                    }
                }
            })
            .catch(error => {
              responseMessage.innerHTML = '<div class="alert alert-danger">An error occurred while processing your request.</div>';
              // Log error to console for debugging
              console.log("Fetch error:", error);
          });
        });
    </script>
</body>
</html>
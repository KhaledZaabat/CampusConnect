<?php
session_start();
require 'headerStud.php';

if (!isset($_SESSION['user']['Id'])) {
    die("Unauthorized access.");
}
$studentId = $_SESSION['user']['Id'];
$message = ""; // For success or error messages

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capture and sanitize form inputs
    $problemType = htmlspecialchars(trim($_POST['problem-type']));
    $description = htmlspecialchars(trim($_POST['problem-description']));
    $urgency = htmlspecialchars(trim($_POST['urgency']));
    $reportedBefore = htmlspecialchars(trim($_POST['reported-before'])) === 'yes' ? true : false;

    // Validate inputs
    if (empty($problemType) || empty($description) || empty($urgency)) {
        $message = "Please fill in all required fields.";
    } else {
        // File upload handling
        $uploadDir = 'uploads/IssuesPhotos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filePath = "uploads\\IssuesPhotos\\Default.png"; // Default to no file
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $allowedExtensions)) {
                $message = "Invalid file type. Please upload an image.";
            } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) { // 2MB limit
                $message = "File size exceeds the limit of 2MB.";
            } else {
                // Generate unique file name
                $fileName = $studentId . '_' . time() . '.' . $fileExtension;
                $filePath = $uploadDir . $fileName;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                    $message = "Error saving uploaded file.";
                }
            }
        }

        // Insert issue into database if there are no errors

        if (empty($message)) {

            $query = $conn->prepare(
                "INSERT INTO issue (description, type, urgency, duplicated, studentId, img_path) 
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            if ($query) {
                $query->bind_param("sssiis", $description, $problemType, $urgency, $reportedBefore, $studentId, $filePath);
                if ($query->execute()) {
                    $message = "Issue reported successfully!";
                } else {
                    $message = "Failed to report the issue.";
                }
            } else {
                $message = "Query preparation failed: " . $conn->error;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Report Issues</title> <!-- Static title for the Home page -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- bootstrap -->
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css"> <!-- fonts -->
    <link rel="stylesheet" href="assets/css/ReportIssues.css"> <!-- custom css -->
    <link rel="stylesheet" href="assets/css/lostfound.css"> <!-- custom css -->
    <script src="assets/js/reportIssues.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- custom css -->
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <script src="assets/js/navbar.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <script src="assets/js/navbar.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>



<body>

    <div class="Form-container">
        <h1>Campus Problem Declaration Form</h1>
        <form id="problem-form" action="reportIssues.php" method="post" enctype="multipart/form-data">
            <!-- Problem Type -->
            <label for="problem-type">Problem Type</label>
            <select id="problem-type" name="problem-type">
                <option value="">Select a Problem Type</option>
                <option value="maintenance">Maintenance Issue</option>
                <option value="roommate">Roommate Issues</option>
                <option value="noise">Noise Complaints</option>
                <option value="internet">Internet Issues</option>
                <option value="cleanliness">Cleanliness/Sanitation</option>
                <option value="security">Security/Safety Concern</option>
                <option value="other">Other</option>
            </select>
            <span class="error-message" id="type-error"></span>

            <!-- Problem Description -->
            <label for="problem-description">Short Description</label>
            <textarea id="problem-description" name="problem-description" rows="4"></textarea>
            <span class="error-message" id="description-error"></span>

            <!-- Urgency Level -->
            <label for="urgency">Urgency Level</label>
            <select id="urgency" name="urgency">
                <option value="">Select Urgency Level</option>
                <option value="low">Low (Can wait a few days)</option>
                <option value="medium">Medium (Needs to be addressed soon)</option>
                <option value="high">High (Requires immediate attention)</option>
            </select>
            <span class="error-message" id="urgency-error"></span>

            <!-- File Upload -->
            <label for="Media">Add an image (Optional)</label>
            <div class="form-group mt-2">
                <label for="file" class="custom-file-upload">
                    <div class="icon" id="upload-icon"></div>
                    <div class="text" id="upload-text">
                        <span>Click to upload image</span>
                    </div>
                    <input id="file" type="file" name="image" accept="image/*" onchange="previewImage(event)">
                </label>
                <div id="image-preview" style="display: none; margin-top: 10px;">
                    <img id="preview-img" src="" alt="Image Preview" style="max-width: 100px; max-height: 100px;">
                    <p>Image uploaded!</p>
                </div>
            </div>

            <!-- Reported Before -->
            <label for="reported-before">Has this been reported before?</label>
            <select id="reported-before" name="reported-before">
                <option value="">Select an Option</option>
                <option value="no">No</option>
                <option value="yes">Yes</option>
            </select>
            <span class="error-message" id="reported-error"></span>

            <!-- Confirmation -->
            <label class="checkbox">
                <input type="checkbox" id="confirm" name="confirm">
                I confirm that the above information is correct and understand that dorm management will address my
                issue as soon as possible.
            </label>
            <span class="error-message" id="confirm-error"></span>

            <!-- Submit Button -->
            <button type="submit">Submit</button>
        </form>
    </div>
    <?php include 'footer.php' ?>

</body>




</html>
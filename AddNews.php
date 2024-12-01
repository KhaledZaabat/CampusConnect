<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Add News</title> <!-- Static title for the Home page -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- bootstrap -->
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css"> <!-- fonts -->
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- custom css -->
    <link rel="stylesheet" href="assets/css/AddNews.css"> <!-- custom css -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/AddNew.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <!-- font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
</head>



<body>
    <?php include 'headerAdmin.php'; ?>
    <div class="form-new">
        <div class="news-form-container">
            <h1>Add News</h1>
            <form id="news-form" action="#" method="post">
                <label for="news-title">News Title</label>
                <input type="text" id="news-title" name="news-title" placeholder="Enter news title">
                <div id="title-error" class="error-message">You must fill in this field.</div>

                <div class="text-editor-toolbar">
                    <button type="button" id="add-media-btn" title="Add media"><i class="fas fa-photo-video"></i> Add media</button>
                    <button type="button" id="add-table-btn" title="Add table"><i class="fas fa-table"></i> Add table</button>
                    <button type="button" data-command="bold" title="Bold"><i class="fas fa-bold"></i></button>
                    <button type="button" data-command="italic" title="Italic"><i class="fas fa-italic"></i></button>
                    <button type="button" data-command="underline" title="Underline"><i class="fas fa-underline"></i></button>
                    <button type="button" id="add-link-btn" title="Add link"><i class="fas fa-link"></i></button>
                    <button type="button" id="color-btn" title="Change text color"><i class="fas fa-palette"></i></button>
                    <input type="file" id="media-file-input" style="display: none;" accept="image/*,video/*">
                    <input type="color" id="color-picker" style="display: none;">
                </div>
                <div id="news-content" contenteditable="true" style="border: 1px solid #ccc; padding: 10px; border-radius: 4px; min-height: 200px;"></div>
                <div id="content-error" class="error-message">You must fill in this field.</div>
                <!-- Link Modal -->
                <div id="linkModal" class="modal">
                    <div class="modal-content">
                        <span class="close" id="linkModalClose">&times;</span>
                        <label for="linkUrl">Enter URL:</label>
                        <input type="text" id="linkUrl" name="linkUrl" placeholder="http://">
                        <button type="button" id="linkSubmit">Add Link</button>
                    </div>
                </div>
                
                <!-- Table Modal -->
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

                <!-- Color Picker Modal -->
<div id="colorModal" class="modal">
    <div class="modal-content">
        <span class="close" id="colorModalClose">&times;</span>
        <label for="colorPicker">Choose Color:</label>
        <input type="color" id="colorPicker">
        <button id="colorSubmit">Apply Color</button>
    </div>
</div>

            
                <div class="buttons-container">
                    <button type="submit" class="submit btn-publish">Publish</button>
                </div>
            </form>
            
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>


</html>
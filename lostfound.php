<?php 

session_start();
if ($_SESSION['user']['isStud'] === true) {
    require 'headerStud.php';
} else {
    require 'headerAdmin.php';
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Lost & Found</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css"> <!-- Fonts -->
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- Custom CSS -->
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <link rel="stylesheet" href="assets/css/lostfound.css"> <!-- Lost & Found Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

<main id="page" class="page" data-is-admin="<?= $_SESSION['user']['Role'] ?>" data-user-id="<?= $_SESSION['user']['Id'] ?>">
    <div class="text-start container-form container post">
        <div class="row">
            <div class="col">
                <h3>Create a new listing:</h3>
                <form id="lostandfound_form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title</label> 
                        <input id="i_title" type="text" class="text-field" id="title" name="title" placeholder="Title" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="description">Description</label> 
                        <textarea id="i_description" rows="3" class="text-field" id="description" name="description" placeholder="Description" required></textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label for="file" class="custom-file-upload">
                            <div class="icon" id="upload-icon">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" fill="#007bff"></path>
                                </svg>
                            </div>
                            <div class="text" id="upload-text">
                                <span>Click to upload image</span>
                            </div>
                            <input id="file" type="file" name="image" accept="image/*" onchange="previewImage(event)" required>
                        </label>
                        <!--not displayed until the user uploads a -->
                        <div id="image-preview" style="display: none; margin-top: 10px;">
                            <img id="preview-img" src="" alt="Image Preview" style="max-width: 100px; max-height: 100px;">
                            <p>Image uploaded!</p>
                        </div>
                    </div>
                    
                    <div class="form-group mt-2">
                        <label>Type of Listing</label>
                        <div class="form-check">
                            <input id="missing" class="form-check-input" type="radio" name="listingType" value="missing" required>
                            <label class="form-check-label" for="missing">
                                Missing
                            </label>
                        </div>
                        <div class="form-check">
                            <input id="found" class="form-check-input" type="radio" name="listingType" value="found" required>
                            <label class="form-check-label" for="found">
                                Found
                            </label>
                        </div>
                    </div>                    
                    <div class="form-group mt-2 mb-4">
                        <button id="submit_btn" class="create-btn" type="submit">Create</button>
                    </div>
                </form>
            </div>            
        </div>
    </div>

    

<!-- Posts Section -->
<div class="container-form container posts">
    <div class="row mt-4">
        <div class="col-md-3 offset-md-10">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter"></i>filter
                </a>

                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item filter" href="#!">All Listings</a></li>
                    <li><a class="dropdown-item filter" href="#!">Missing Listings</a></li>
                    <li><a class="dropdown-item filter" href="#!">Found Listings</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="blog_posts" class="row mt-n5">
    </div>
    <div id="pagination" class="pagination"></div>
</div>


</main>




<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/helperFunctions.js"></script>
<script src="assets/js/lostfound.js"></script>
<?php include 'footer.php' ?>
</body>
</html>


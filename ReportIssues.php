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
    <!-- font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
</head>

<header>
    <nav class="navbar navbar-expand-lg fixed-top bg-body clean-navbar">
        <div class="container">
            <a class="navbar-brand-logo" href="#">
                <img class="logo_img" src="assets/img/logo.png" alt="Brand Logo"> 
            </a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item active"><a class="nav-link" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="news.html">News</a></li>
                    <li class="nav-item"><a class="nav-link" href="Canteen.html">Canteen Schedule</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li class="dropdown-header">Maintenance Services</li>
                            <li><a class="dropdown-item" href="ReportIssues.html">Report Issues</a></li>
                            <li><a class="dropdown-item" href="lostfound.html">Lost&Found items</a></li>
                            <li class="dropdown-header">Housing Services</li>
                            <li><a class="dropdown-item" href="BookRoom.html">Book Rooms</a></li>
                            <li><a class="dropdown-item" href="changeRoom.html">Change Rooms</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- profile section for pc -->
                <div class="dropdown d-none d-lg-block me-3">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="StudentProfile.html">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
                

                <!-- Profile and Sign-out links for smaller screens(phone) -->
                <ul class="navbar-nav d-lg-none">
                    <li><hr class="dropdown-divider my-1"></li>
                    <li class="nav-item"><a class="nav-link" href="StudentProfile.html">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Sign out</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<body>
    <div class="Form-container">
        <h1>Campus Problem Declaration Form</h1>
        <form id="problem-form" action="#" method="post" enctype="multipart/form-data">

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
                    <div class="icon" id="upload-icon">
                        <!-- SVG icon here -->
                    </div>
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
                I confirm that the above information is correct and understand that dorm management will address my issue as soon as possible.
            </label>
            <span class="error-message" id="confirm-error"></span>

            <!-- Submit Button -->
            <button type="submit">Submit</button>
        </form>
    </div>
</body>


<footer class="page-footer custom-bg-black">
    <div class="test">
        <div class="wrapper">
            <div class="button">
                <div class="icon"><i class="fab fa-facebook-f"></i></div>
                <span>Facebook</span>
            </div>

            <div class="button">
                <div class="icon"><i class="fab fa-twitter"></i></div>
                <span>Twitter</span>
            </div>

            <div class="button">
                <div class="icon"><i class="fab fa-youtube"></i></div>
                <span>Youtube</span>
            </div>

            <div class="button">
                <div class="icon"><i class="fab fa-github"></i></div>
                <span>Github</span>
            </div>
            
            <div class="button">
                <div class="icon"><i class="fab fa-instagram"></i></div>
                <span>Instagram</span>
            </div>
        </div>

        <div class="footer-image">
            <img src="assets/img/logo.png" alt="Footer Image" />
        </div>

    </div>
    
    <div class="text-center custom-bg-black p-1">
        <p>©ENSIA. All Rights Reserved.</p>
    </div>
</footer>


</html>


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
                    <li id="nav-item" class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li id="nav-item" class="nav-item"><a class="nav-link" href="news.php">News</a></li>
                    <li id="nav-item" class="nav-item"><a class="nav-link" href="Canteen.php">Canteen Schedule</a></li>
                    <li id="nav-drop" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li class="dropdown-header">Maintenance Services</li>
                            <li><a class="dropdown-item" href="ReportIssues.php">Report Issues</a></li>
                            <li><a class="dropdown-item" href="lostfound.php">Lost&Found items</a></li>
                            <li class="dropdown-header">Housing Services</li>
                            <li><a class="dropdown-item" href="BookRoom.php">Book Rooms</a></li>
                            <li><a class="dropdown-item" href="changeRoom.php">Change Rooms</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- profile section for pc -->
                <div class="dropdown d-none d-lg-block me-3">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="StudentProfile.php">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
                

                <!-- Profile and Sign-out links for smaller screens(phone) -->
                <ul class="navbar-nav d-lg-none">
                    <li><hr class="dropdown-divider my-1"></li>
                    <li class="nav-item"><a class="nav-link" href="StudentProfile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Sign out</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>



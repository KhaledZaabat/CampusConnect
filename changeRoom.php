<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Book Room</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/css/Rooms.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Rooms.js"></script>

    <link rel="icon" href="assets/img/logo.png" type="image/png">
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
    <div class="available-rooms">
        <h2>Available Rooms</h2>
        <input type="text" class="search-input form-control" id="search" placeholder="Search for rooms...">
        <table class="table">
            <tr>
                <th data-column="block" class="sortable">Dorm Block <span class="sort-icon">⇅</span></th>
                <th data-column="floor" class="sortable">Floor <span class="sort-icon">⇅</span></th>
                <th data-column="number" class="sortable">Room Number <span class="sort-icon">⇅</span></th>
            </tr>
            
            <tbody id="room-table-body">
               
                <tr>
                    <td>D</td>
                    <td>4</td>
                    <td>25</td>
                </tr>
                <tr>
                    <td>E</td>
                    <td>5</td>
                    <td>30</td>
                </tr>
                <tr>
                    <td>A</td>
                    <td>1</td>
                    <td>6</td>
                </tr>
                
                <tr>
                    <td>C</td>
                    <td>5</td>
                    <td>18</td>
                </tr>
                
                <tr>
                    <td>B</td>
                    <td>5</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>B</td>
                    <td>2</td>
                    <td>11</td>
                </tr>
                <tr>
                    <td>C</td>
                    <td>3</td>
                    <td>16</td>
                </tr>
                <tr>
                    <td>D</td>
                    <td>4</td>
                    <td>21</td>
                </tr>
                <tr>
                    <td>E</td>
                    <td>5</td>
                    <td>26</td>
                </tr>
                <tr>
                    <td>A</td>
                    <td>2</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>B</td>
                    <td>3</td>
                    <td>12</td>
                </tr>
                <tr>
                    <td>A</td>
                    <td>R</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>A</td>
                    <td>1</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>B</td>
                    <td>2</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td>C</td>
                    <td>3</td>
                    <td>20</td>
                </tr>
                <tr>
                    <td>C</td>
                    <td>4</td>
                    <td>17</td>
                </tr>
                <tr>
                    <td>D</td>
                    <td>5</td>
                    <td>22</td>
                </tr>
                <tr>
                    <td>E</td>
                    <td>6</td>
                    <td>27</td>
                </tr>
                <tr>
                    <td>A</td>
                    <td>3</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>B</td>
                    <td>4</td>
                    <td>13</td>
                </tr>
                <tr>
                    <td>C</td>
                    <td>6</td>
                    <td>19</td>
                </tr>
                <tr>
                    <td>D</td>
                    <td>7</td>
                    <td>24</td>
                </tr>
                <tr>
                    <td>D</td>
                    <td>6</td>
                    <td>23</td>
                </tr>
                <tr>
                    <td>E</td>
                    <td>7</td>
                    <td>28</td>
                </tr>
                <tr>
                    <td>A</td>
                    <td>4</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>E</td>
                    <td>8</td>
                    <td>29</td>
                </tr>
                
            </tbody>
        </table>
        <div class="pagination">
            <button id="prev" disabled><i class="fas fa-arrow-left"></i></button>
            <span id="page-num">1</span>
            <button id="next"><i class="fas fa-arrow-right"></i></button>
        </div>
    </div>
    


    <div class="Form-container">
        <h1>Change Room Request Form</h1>
        <form action="#" method="post" >

            <!-- New Room Preferences -->
            <label for="dorm-block">Dorm Block Preference</label>
            <select id="dorm-block" name="dorm-block">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
            </select>

            <!-- Floor Selection -->
            <label for="floor">Floor</label>
            <select id="floor" name="floor">
                <option value="R">R</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

            <!-- Room Number -->
            <label for="room-number">Room Number</label>
            <input type="number" id="room-number" name="room-number" min="1" max="40">
            <div id="room-number-error" class="error-message">You must fill in this field.</div>

            <!-- Reason for Change -->
            <label for="reason">Reason for Change (must be convenient)</label>
<textarea id="reason" name="reason" rows="4"></textarea>
<div id="reason-error" class="error-message">You must provide a reason for the change.</div>


            <!-- Confirmation -->
                <label class="checkbox">
                    I confirm that the information provided is correct and understand that my request will be reviewed.
                    <input type="checkbox" name="confirm" id="confirm-checkbox">
                </label>
                <div id="checkbox-error" class="error-message">You must confirm that the information provided is correct.</div>

            <!-- Submit Button -->
            <button class="submit" type="submit">Submit</button>
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
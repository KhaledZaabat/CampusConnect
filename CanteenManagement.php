<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Canteen Management</title> <!-- Static title for the Home page -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- bootstrap -->
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css"> <!-- fonts -->
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- custom css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/canteen.css">
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <!-- font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                  <li class="nav-item active"><a class="nav-link" href="AdminHome.html">Home</a></li>
                  <li class="nav-item"><a class="nav-link" href="AdminNews.html">News</a></li>
                  <li class="nav-item"><a class="nav-link" href="CanteenManagement.html">Canteen Schedule</a></li>
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                      <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                          <li class="dropdown-header">Maintenance Services</li>
                          <li><a class="dropdown-item" href="ReceivingIssues.html">Manage Issues</a></li>
                          <li><a class="dropdown-item" href="lostfound.html">Lost&Found items</a></li>
                          <li class="dropdown-header">Housing Services</li>
                          <li><a class="dropdown-item" href="#">Book Rooms</a></li>
                          <li><a class="dropdown-item" href="roomRequests.html">Change Rooms</a></li>
                          <li class="dropdown-header">Users</li>
                          <li><a class="dropdown-item" href="crudstud.html"> Manage Students</a></li>
                          <li><a class="dropdown-item" href="crudadmin.html"> Manage Employees</a></li>
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
                  <li class="nav-item"><a class="nav-link" href="UserProfile.html">Profile</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Sign out</a></li>
              </ul>
          </div>
      </div>
  </nav>
</header>

<body>

    <h1>Canteen Schedule</h1>

    <table class="canteenTable">
        <thead>
            <tr>
                <th>Day</th>
                <th>Meal</th>
                <th>Details</th>
                <th>Weight/Amount</th>
            </tr>
        </thead>
        <tbody>
            <!-- Sunday -->
            <tr>
              <td rowspan="3">Sunday</td>
              <td>Breakfast</td>
              <td class="input-container">
                <input type="text" value="Milk" disabled> <br>
                <input type="text" value="Croissant" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
              <td class="input-container">
                <input type="text" value="1 Cup" disabled> <br>
                <input type="text" value="1 Piece" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
            <tr>
              <td>Lunch</td>
              <td class="input-container">
                <input type="text" value="Bread" disabled> <br>
                <input type="text" value="عدس" disabled> <br>
                <input type="text" value="Eggs" disabled> <br>
                <input type="text" value="Salad (Tomato Carrot ...)" disabled> <br>
                <input type="text" value="Juice" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                </div>
              </td>
              <td class="input-container">
                <input type="text" value="One piece" disabled> <br>
                <input type="text" value="100g" disabled> <br>
                <input type="text" value="Two pieces" disabled> <br>
                <input type="text" value="150g" disabled> <br>
                <input type="text" value="One piece" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
            <tr>
              <td>Dinner</td>
              <td class="input-container">
                <input type="text" value="Bread" disabled> <br>
                <input type="text" value="Soup" disabled> <br>
                <input type="text" value="مثوم" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td class="input-container">
              <td>
                <input type="text" value="200g" disabled> <br>
                <input type="text" value="50g" disabled> <br>
                <input type="text" value="1 piece" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
        
            <!-- Monday -->
            <tr>
              <td rowspan="3">Monday</td>
              <td>Breakfast</td>
              <td class="input-container">
                <input type="text" value="Omelette" disabled> <br>
                <input type="text" value="Toast" disabled> <br>
                <input type="text" value="Juice" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
              <td class="input-container">
                <input type="text" value="100g" disabled> <br>
                <input type="text" value="2 pieces" disabled> <br>
                <input type="text" value="200ml" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
            <tr>
              <td>Lunch</td>
              <td class="input-container">
                <input type="text" value="Beef Stew" disabled> <br>
                <input type="text" value="Mashed Potatoes" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
              <td class="input-container">
                <input type="text" value="200g" disabled> <br>
                <input type="text" value="150g" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
            <tr>
              <td>Dinner</td>
              <td class="input-container">
                <input type="text" value="Vegetable Soup" disabled> <br>
                <input type="text" value="Bread" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
              <td class="input-container">
                <input type="text" value="1 bowl" disabled> <br>
                <input type="text" value="1 piece" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
        
            <!-- Tuesday -->
            <tr>
              <td rowspan="3">Tuesday</td>
              <td>Breakfast</td>
              <td class="input-container">
                <input type="text" value="Bread" disabled> <br>
                <input type="text" value="Cheese" disabled> <br>
                <input type="text" value="Jam" disabled> <br>
                <input type="text" value="Milk" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
              <td class="input-container">
                <input type="text" value="1 piece" disabled> <br>
                <input type="text" value="50g" disabled> <br>
                <input type="text" value="1 serving" disabled> <br>
                <input type="text" value="200ml" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
            <tr>
              <td>Lunch</td>
              <td class="input-container">
                <input type="text" value="Grilled Chicken" disabled> <br>
                <input type="text" value="Rice" disabled> <br>
                <input type="text" value="Salad" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
              <td class="input-container">
                <input type="text" value="150g" disabled> <br>
                <input type="text" value="100g" disabled> <br>
                <input type="text" value="1 bowl" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
            <tr>
              <td>Dinner</td>
              <td class="input-container">
                <input type="text" value="Spaghetti" disabled> <br>
                <input type="text" value="Tomato Sauce" disabled> <br>
                <input type="text" value="Bread" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
              <td class="input-container">
                <input type="text" value="200g" disabled> <br>
                <input type="text" value="50g" disabled> <br>
                <input type="text" value="1 piece" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
        
            <!-- Wednesday -->
            <tr>
              <td rowspan="3">Wednesday</td>
              <td>Breakfast</td>
              <td class="input-container">
                <input type="text" value="Omelette" disabled> <br>
                <input type="text" value="Toast" disabled> <br>
                <input type="text" value="Juice" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
              <td class="input-container">
                <input type="text" value="100g" disabled> <br>
                <input type="text" value="2 pieces" disabled> <br>
                <input type="text" value="200ml" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
            <tr>
              <td>Lunch</td>
              <td class="input-container">
                <input type="text" value="Beef Stew" disabled> <br>
                <input type="text" value="Mashed Potatoes" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
              <td class="input-container">
                <input type="text" value="200g" disabled> <br>
                <input type="text" value="150g" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
            <tr>
              <td>Dinner</td>
              <td class="input-container">
                <input type="text" value="Vegetable Soup" disabled> <br>
                <input type="text" value="Bread" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
              <td class="input-container">
                <input type="text" value="1 bowl" disabled> <br>
                <input type="text" value="1 piece" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
        
            <!-- Thursday -->
            <tr>
              <td rowspan="3">Thursday</td>
              <td>Breakfast</td>
              <td class="input-container">
                <input type="text" value="Bread" disabled> <br>
                <input type="text" value="Cheese" disabled> <br>
                <input type="text" value="Jam" disabled> <br>
                <input type="text" value="Milk" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
              <td class="input-container">
                <input type="text" value="1 piece" disabled> <br>
                <input type="text" value="50g" disabled> <br>
                <input type="text" value="1 serving" disabled> <br>
                <input type="text" value="200ml" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
            <tr>
              <td>Lunch</td>
              <td class="input-container">
                <input type="text" value="Grilled Chicken" disabled> <br>
                <input type="text" value="Rice" disabled> <br>
                <input type="text" value="Salad" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
              <td class="input-container">
                <input type="text" value="150g" disabled> <br>
                <input type="text" value="100g" disabled> <br>
                <input type="text" value="1 bowl" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
            <tr>
              <td>Dinner</td>
              <td class="input-container">
                <input type="text" value="Spaghetti" disabled> <br>
                <input type="text" value="Tomato Sauce" disabled> <br>
                <input type="text" value="Bread" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
              <td class="input-container">
                <input type="text" value="200g" disabled> <br>
                <input type="text" value="50g" disabled> <br>
                <input type="text" value="1 piece" disabled>
                <div class="button-container">
                  <button type="button" class="add"><i class="fas fa-add"></i></button>
                  <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
              </div>
              </td>
            </tr>
                    <!--6 day-->
                    <tr>
                        <td rowspan="3">Friday</td>
                        <td>Breakfast</td>
                        <td class="input-container">
                          <input type="text" value="Bread" disabled> <br>
                          <input type="text" value="Cheese" disabled> <br>
                          <input type="text" value="Jam" disabled> <br>
                          <input type="text" value="Milk" disabled>
                          <div class="button-container">
                            <button type="button" class="add"><i class="fas fa-add"></i></button>
                            <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        </td>
                        <td class="input-container">
                          <input type="text" value="1 piece" disabled> <br>
                          <input type="text" value="50g" disabled> <br>
                          <input type="text" value="1 serving" disabled> <br>
                          <input type="text" value="200ml" disabled>
                          <div class="button-container">
                            <button type="button" class="add"><i class="fas fa-add"></i></button>
                            <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Lunch</td>
                        <td class="input-container">
                          <input type="text" value="Grilled Chicken" disabled> <br>
                          <input type="text" value="Rice" disabled> <br>
                          <input type="text" value="Salad" disabled>
                          <div class="button-container">
                            <button type="button" class="add"><i class="fas fa-add"></i></button>
                            <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        </td>
                        <td class="input-container">
                          <input type="text" value="150g" disabled> <br>
                          <input type="text" value="100g" disabled> <br>
                          <input type="text" value="1 bowl" disabled>
                          <div class="button-container">
                            <button type="button" class="add"><i class="fas fa-add"></i></button>
                            <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Dinner</td>
                        <td class="input-container">
                          <input type="text" value="Spaghetti" disabled> <br>
                          <input type="text" value="Tomato Sauce" disabled> <br>
                          <input type="text" value="Bread" disabled>
                          <div class="button-container">
                            <button type="button" class="add"><i class="fas fa-add"></i></button>
                            <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        </td>
                        <td class="input-container">
                          <input type="text" value="200g" disabled> <br>
                          <input type="text" value="50g" disabled> <br>
                          <input type="text" value="1 piece" disabled>
                          <div class="button-container">
                            <button type="button" class="add"><i class="fas fa-add"></i></button>
                            <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        </td>
                      </tr>
                  
                      <!-- Saturday -->
                      <tr>
                        <td rowspan="3">Saturday</td>
                        <td>Breakfast</td>
                        <td class="input-container">
                          <input type="text" value="Bread" disabled> <br>
                          <input type="text" value="Cheese" disabled> <br>
                          <input type="text" value="Jam" disabled> <br>
                          <input type="text" value="Milk" disabled>
                          <div class="button-container">
                            <button type="button" class="add"><i class="fas fa-add"></i></button>
                            <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        </td>
                        <td class="input-container">
                          <input type="text" value="1 piece" disabled> <br>
                          <input type="text" value="50g" disabled> <br>
                          <input type="text" value="1 serving" disabled> <br>
                          <input type="text" value="200ml" disabled>
                          <div class="button-container">
                            <button type="button" class="add"><i class="fas fa-add"></i></button>
                            <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Lunch</td>
                        <td class="input-container">
                          <input type="text" value="Grilled Chicken" disabled> <br>
                          <input type="text" value="Rice" disabled> <br>
                          <input type="text" value="Salad" disabled>
                          <div class="button-container">
                            <button type="button" class="add"><i class="fas fa-add"></i></button>
                            <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        </td>
                        <td class="input-container">
                          <input type="text" value="150g" disabled> <br>
                          <input type="text" value="100g" disabled> <br>
                          <input type="text" value="1 bowl" disabled>
                          <div class="button-container">
                            <button type="button" class="add"><i class="fas fa-add"></i></button>
                            <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Dinner</td>
                        <td class="input-container">
                          <input type="text" value="Spaghetti" disabled> <br>
                          <input type="text" value="Tomato Sauce" disabled> <br>
                          <input type="text" value="Bread" disabled>
                          <div class="button-container">
                            <button type="button" class="add"><i class="fas fa-add"></i></button>
                            <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        </td>
                        <td class="input-container">
                          <input type="text" value="200g" disabled> <br>
                          <input type="text" value="50g" disabled> <br>
                          <input type="text" value="1 piece" disabled>
                          <div class="button-container">
                            <button type="button" class="add"><i class="fas fa-add"></i></button>
                            <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        </td>
                      </tr>
        </tbody>
    </table>

    <button class="edit">Edit</button>

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




 <script src="assets/js/canteen.js"></script>
  
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</html>

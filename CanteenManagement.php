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


<body>
  <?php include 'headerAdmin.php' ?>
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
    <?php include 'footer.php' ?>
</body>




 <script src="assets/js/canteen.js"></script>
  
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</html>

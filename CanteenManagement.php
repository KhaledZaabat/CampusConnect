<?php
session_start();
if ( $_SESSION['user']['Role'] !== 'Admin' && $_SESSION['user']['Role'] !== 'Chef'){
    die("just admins and Chefs can access this page");
}
  require 'headerAdmin.php' ;


// Fetch all days
$query_days = "SELECT * FROM days ORDER BY id";
$result_days = mysqli_query($conn, $query_days);
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Canteen Management</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/canteen.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

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
            <?php
            while ($day = mysqli_fetch_assoc($result_days)) {
                $query_types = "SELECT DISTINCT mt.* FROM mealtype mt 
                               JOIN meals m ON m.typeid = mt.id 
                               WHERE m.dayid = {$day['id']}
                               ORDER BY mt.id";
                $result_types = mysqli_query($conn, $query_types);
                $type_count = mysqli_num_rows($result_types);
                
                $first_type = true;
                while ($type = mysqli_fetch_assoc($result_types)) {
                    echo $first_type ? "<tr><td rowspan=\"$type_count\" data-day-id=\"{$day['id']}\">{$day['day']}</td>" : "<tr>";                    
                    $query_meals = "SELECT id, meal, amount FROM meals 
                                  WHERE dayid = {$day['id']} 
                                  AND typeid = {$type['id']}";
                    $result_meals = mysqli_query($conn, $query_meals);
                    
                    echo "<td data-type-id=\"{$type['id']}\">{$type['type']}</td><td class=\"input-container\">";                    while ($meal = mysqli_fetch_assoc($result_meals)) {
                        echo "<input type=\"text\" value=\"{$meal['meal']}\" data-id=\"{$meal['id']}\" disabled><br>";
                    }
                    echo '<div class="button-container">
                            <button type="button" class="add"><i class="fas fa-add"></i></button>
                            <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                          </div></td><td class="input-container">';
                    
                    mysqli_data_seek($result_meals, 0);
                    while ($meal = mysqli_fetch_assoc($result_meals)) {
                        echo "<input type=\"text\" value=\"{$meal['amount']}\" data-id=\"{$meal['id']}\" disabled><br>";
                    }
                    echo '<div class="button-container">
                            <button type="button" class="add"><i class="fas fa-add"></i></button>
                            <button type="button" class="Delete"><i class="fas fa-trash-alt"></i></button>
                          </div></td></tr>';
                    
                    $first_type = false;
                }
            }
            ?>
        </tbody>
    </table>
    <button class="edit">Edit</button>
    
    <?php include 'footer.php' ?>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/canteen.js"></script>

</body>
</html>
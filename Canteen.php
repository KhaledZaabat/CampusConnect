<?php
session_start();
require 'headerStud.php';

// Fetch all days
$query_days = "SELECT * FROM days ORDER BY id";
$result_days = mysqli_query($conn, $query_days);
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Canteen</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/canteen.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <script src="assets/js/navbar.js"></script>
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
                // Get meal types
                $query_types = "SELECT DISTINCT mt.* FROM mealtype mt 
                               JOIN meals m ON m.typeid = mt.id 
                               WHERE m.dayid = {$day['id']}
                               ORDER BY mt.id";
                $result_types = mysqli_query($conn, $query_types);
                $type_count = mysqli_num_rows($result_types);
                
                $first_type = true;
                while ($type = mysqli_fetch_assoc($result_types)) {
                    echo $first_type ? "<tr><td rowspan=\"$type_count\">{$day['day']}</td>" : "<tr>";
                    
                    // Get meals for this day and type
                    $query_meals = "SELECT meal, amount FROM meals 
                                  WHERE dayid = {$day['id']} 
                                  AND typeid = {$type['id']}";
                    $result_meals = mysqli_query($conn, $query_meals);
                    
                    echo "<td>{$type['type']}</td><td>";
                    while ($meal = mysqli_fetch_assoc($result_meals)) {
                        echo "{$meal['meal']}<br>";
                    }
                    echo "</td><td>";
                    
                    mysqli_data_seek($result_meals, 0);
                    while ($meal = mysqli_fetch_assoc($result_meals)) {
                        echo "{$meal['amount']}<br>";
                    }
                    echo "</td></tr>";
                    
                    $first_type = false;
                }
            }
            ?>
        </tbody>
    </table>
    <?php include 'footer.php' ?>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
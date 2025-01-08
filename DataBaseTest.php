<?php

$db_server = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "campus_connect";
$conn = "";
$conn = mysqli_connect(
    $db_server,
    $db_user,
    $db_password,
    $db_name
);
if ($conn) {
    echo "GG";
} else {
    echo "Not GG";
}
?>
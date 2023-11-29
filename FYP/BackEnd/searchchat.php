<?php
session_start();
include_once "connection.php";
if (!isset($_SESSION['unique_id'])) {
    header("location: ../login.php"); 
    exit();
} else {
    $outgoing_id = $_SESSION['unique_id'];
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
    $sql = "SELECT * FROM users WHERE NOT unique_id = '{$outgoing_id}' AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') ";
    $output = "";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) == 0) {
        $output .= "No users are available to chat";
    } elseif (mysqli_num_rows($query) > 0) {
        include_once "chatinfo.php";
    }
    echo $output;
}
?>



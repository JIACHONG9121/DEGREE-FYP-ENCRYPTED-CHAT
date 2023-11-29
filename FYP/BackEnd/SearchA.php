<?php
session_start();
include_once "connection.php";
$outgoing_id = $_SESSION['unique_id'];

$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

$sql = "
    (
        SELECT 'Student' AS role, unique_id, fname, lname, img FROM student
        WHERE (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%')
        AND NOT unique_id = '{$outgoing_id}'
    )
    UNION
    (
        SELECT 'Lecturer' AS role, unique_id, fname, lname, img FROM lecturer
        WHERE (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%')
        AND NOT unique_id = '{$outgoing_id}'
    )
    UNION
    (
        SELECT 'Admin' AS role, unique_id, fname, lname, img FROM admin
        WHERE (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%')
        AND NOT unique_id = '{$outgoing_id}'
    )
    ORDER BY role, fname, lname, img;
";

$output = "";
$query = mysqli_query($conn, $sql);

if(mysqli_num_rows($query) > 0){
    include_once "userlist.php";
}else{
    $output .= 'No user found related to your search term';
}
echo $output;
?>

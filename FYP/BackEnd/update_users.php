<?php
session_start();
include_once "connection.php";

if (isset($_SESSION['unique_id']) && isset($_GET['user_id'])) {
    $viewer_id = $_SESSION['unique_id'];
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['status']); 

 
    $table_name = '';
    if (strpos($user_id, 'AP') === 0) {
        $table_name = 'admin';
    } elseif (strpos($user_id, 'LP') === 0) {
        $table_name = 'lecturer';
    } elseif (strpos($user_id, 'TP') === 0) {
        $table_name = 'student';
    }

    if (!empty($table_name)) {

        $update_query = "UPDATE {$table_name} SET status = '{$new_status}' WHERE unique_id = '{$user_id}'";

        if (mysqli_query($conn, $update_query)) {

            $status_text = ($new_status == 'active') ? 'Active' : 'Inactive';
            echo '<script>alert("User status updated to ' . $status_text . ' successfully.");</script>';
            echo "<script>window.location.href='../edituser.php?user_id={$user_id}';</script>";
        } else {

            echo "Error updating status: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid user ID prefix.";
    }
} else {
    header("location: ../login.php");
}
?>

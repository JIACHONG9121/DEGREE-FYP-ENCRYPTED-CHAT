<?php
session_start();
include_once "connection.php";

if (isset($_POST['change_password'])) {
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $user_id = $_SESSION['unique_id'];

    $unique_id = mysqli_real_escape_string($conn, $_SESSION['unique_id']);
    $table = '';

    if (strpos($unique_id, 'TP') === 0) {
        $table = 'student';
    } elseif (strpos($unique_id, 'LP') === 0) {
        $table = 'lecturer';
    } elseif (strpos($unique_id, 'AP') === 0) {
        $table = 'admin';
    }

    if ($table !== '') {
        $sql = "SELECT * FROM $table WHERE unique_id = '$user_id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $user = mysqli_fetch_assoc($result);

            $hashed_current_password = $user['password'];

            if (password_verify($current_password, $hashed_current_password)) {
                if (strlen($new_password) < 8) {
                    echo "<script>alert('Password must be at least 8 characters long.');</script>";
                    echo '<script>window.location.href="../changepassword.php";</script>';
                } elseif (!preg_match("#[0-9]+#", $new_password)) {
                    echo "<script>alert('Password must include at least one number.');</script>";
                    echo '<script>window.location.href="../changepassword.php";</script>';
                } elseif (!preg_match("#[A-Z]+#", $new_password)) {
                    echo "<script>alert('Password must include at least one uppercase letter.');</script>";
                    echo '<script>window.location.href="../changepassword.php";</script>';
                } elseif (!preg_match("/[!@#$%^&*()\-_=+{};:,<.>?]+/", $new_password)) {
                    echo "<script>alert('Password must include at least one symbol.');</script>";
                    echo '<script>window.location.href="../changepassword.php";</script>';
                } else {
                    $hashed_new_password = password_hash($new_password,  PASSWORD_BCRYPT);

                    $update_sql = "UPDATE $table SET password = '$hashed_new_password' WHERE unique_id = '$user_id'";
                    $update_result = mysqli_query($conn, $update_sql);

                    if ($update_result) {
                        echo "<script>alert('Password updated successfully.');</script>";
                        echo'<script>window.location.href="../changepassword.php";</script>';
                    } else {
                        echo "<script>alert('Error updating password.');</script>";
                        echo'<script>window.location.href="../changepassword.php";</script>';
                    }
                }
            } else {
                echo "<script>alert('Current password is incorrect.');</script>";
                echo'<script>window.location.href="../changepassword.php";</script>';
            }
        } else {
            echo "<script>alert('Error retrieving user data.');</script>";
            echo'<script>window.location.href="../changepassword.php";</script>';
        }
    } else {
        echo "<script>alert('Invalid user role.');</script>";
        echo'<script>window.location.href="../changepassword.php";</script>';
    }
}
?>

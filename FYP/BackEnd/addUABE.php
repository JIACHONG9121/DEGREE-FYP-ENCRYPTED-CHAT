<?php
session_start();
include_once "connection.php";
$fname = mysqli_real_escape_string($conn, trim($_POST['fname']));
$lname = mysqli_real_escape_string($conn, trim($_POST['lname']));
if (!preg_match("/^[a-zA-Z\s-]+$/", $fname) || !preg_match("/^[a-zA-Z\s-]+$/", $lname)) {
    $error_message = "First name and last name can only contain letters, spaces.";
    echo "<script>alert('" . $error_message . "');</script>";
    echo '<script>window.location.href="../addAU.php";</script>';
    exit;
}
if (strlen($fname) > 20 || strlen($lname) > 20) {
    $error_message = "First name and last name cannot exceed 20 characters.";
    echo "<script>alert('" . $error_message . "');</script>";
    echo '<script>window.location.href="../addAU.php";</script>';
    exit; 
}
$Saddress = mysqli_real_escape_string($conn, trim($_POST['Saddress']));
$phonenumber = mysqli_real_escape_string($conn, trim($_POST['phonenumber']));
$gender = mysqli_real_escape_string($conn, trim($_POST['gender']));
$password = mysqli_real_escape_string($conn, trim($_POST['password']));
$error_message = "";
$prefix = 'AP';
$countQuery = "SELECT COUNT(*) as userCount FROM admin";
$countResult = mysqli_query($conn, $countQuery);
$countData = mysqli_fetch_assoc($countResult);
$userCount = $countData['userCount'] + 1;
$numericPart = str_pad($userCount, 6, '0', STR_PAD_LEFT);
$generatedUserID = $prefix . $numericPart;
$domain = 'mail.apu.edu.my';
$email = $generatedUserID . '@' . $domain;

if (!empty($fname) && !empty($lname) && !empty($Saddress) && !empty($phonenumber) && !empty($gender) && !empty($password)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (preg_match("/^[0-9]{10}$/", $phonenumber)) {
            $sql = mysqli_query($conn, "SELECT * FROM admin WHERE email = '{$email}'");
            if (mysqli_num_rows($sql) > 0) {

                $error_message = $email . " - This email already exists!";
                echo "<script>alert('" . $error_message . "');</script>";
                echo '<script>window.location.href="../addAU.php";</script>';
            } else {
                if (isset($_FILES['image'])) {
                    $img_name = $_FILES['image']['name'];
                    $img_type = $_FILES['image']['type'];
                    $tmp_name = $_FILES['image']['tmp_name'];

                    $img_explode = explode('.', $img_name);
                    $img_ext = end($img_explode);

                    $extensions = ["jpeg", "png", "jpg"];
                    if (in_array($img_ext, $extensions) === true) {
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if (in_array($img_type, $types) === true) {
                            $time = time();
                            $new_img_name = $time . $img_name;
                            if (move_uploaded_file($tmp_name, "images/" . $new_img_name)) {
                                $status = "active";
                                $status2 = "Offline now";
                                $role = "admin";
                                $encrypt_pass = password_hash($password, PASSWORD_BCRYPT);

                                $insert_query = mysqli_query($conn, "INSERT INTO admin (unique_id, fname, lname, address, phonenumber, gender, email, password, img, status)
                                VALUES ('{$generatedUserID}', '{$fname}','{$lname}', '{$Saddress}', '{$phonenumber}', '{$gender}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");


                                $insert_query2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, img, status, role)
                                VALUES ('{$generatedUserID}', '{$fname}','{$lname}', '{$email}', '{$new_img_name}', '{$status2}', '{$role}')");


                                if ($insert_query && $insert_query2) {
                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM admin WHERE email = '{$email}'");
                                    if (mysqli_num_rows($select_sql2) > 0) {
                                        $result = mysqli_fetch_assoc($select_sql2);
                                        $success_message = "Success! Unique ID: " . $result['unique_id'] . " Password: " . $password;
                                        echo "<script>alert('" . $success_message . "');</script>";
                                        echo '<script>window.location.href="../addAU.php";</script>';
                                    } else {
                                        $error_message = "This email address does not exist!";
                                        echo "<script>alert('" . $error_message . "');</script>";
                                        echo '<script>window.location.href="../addAU.php";</script>';

                                    }
                                } else {
                                    $error_message = "Something went wrong. Please try again!";
                                    echo "<script>alert('" . $error_message . "');</script>";
                                    echo '<script>window.location.href="../addAU.php";</script>';

                                }
                            }
                        } else {
                            $error_message = "Please upload an image file - jpeg, png, jpg";
                            echo "<script>alert('" . $error_message . "');</script>";
                            echo '<script>window.location.href="../addAU.php";</script>';

                        }
                    } else {
                        $error_message = "Please upload an image file - jpeg, png, jpg";
                        echo "<script>alert('" . $error_message . "');</script>";
                        echo '<script>window.location.href="../addAU.php";</script>';

                    }
                }
            }
        } else {
            $error_message = "Invalid phone number format!";
            echo "<script>alert('" . $error_message . "');</script>";
            echo '<script>window.location.href="../addAU.php";</script>';

        }
    } else {
        $error_message = "$email is not a valid email!";
        echo "<script>alert('" . $error_message . "');</script>";
        echo '<script>window.location.href="../addAU.php";</script>';

    }
} else {
    $error_message = "All input fields are required!";
    echo "<script>alert('" . $error_message . "');</script>";
    echo '<script>window.location.href="../addAU.php";</script>';
}
?>
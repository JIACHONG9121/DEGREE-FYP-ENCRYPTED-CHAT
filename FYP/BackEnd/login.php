<?php
session_start();
include_once "connection.php";
$error_message = "";


function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}


if (isset($_POST['ID']) && !empty($_POST['ID'])) {
    $ID = sanitizeInput($_POST['ID']);
    
    if (!preg_match("/^[a-zA-Z0-9]*$/", $ID)) {
        $error_message = "Invalid user ID format.";
    }
} 


if (isset($_POST['password']) && !empty($_POST['password'])) {
    $password = sanitizeInput($_POST['password']);
}


if (empty($error_message)) {
    $ID = mysqli_real_escape_string($conn, $ID);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT unique_id, password FROM admin 
    WHERE unique_id = '$ID'
    UNION
   SELECT unique_id, password FROM lecturer
    WHERE unique_id = '$ID'
    UNION
   SELECT unique_id, password FROM student
    WHERE unique_id = '$ID'";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $idPrefix = substr($row['unique_id'], 0, 2);

            if ($idPrefix === 'TP') {

                $query1 = "SELECT * FROM student WHERE unique_id = '$ID'";
                $result1 = mysqli_query($conn, $query1);

                if (mysqli_num_rows($result1) > 0) {
                    $studentRow = mysqli_fetch_assoc($result1);

                    if ($studentRow['status'] === 'inactive') {
                        $error_message = "User is inactive.";
                    } else {

                        $status = "Active now";
                        $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = '{$row['unique_id']}'");
                        if ($sql2) {
                            $_SESSION['unique_id'] = $row['unique_id'];
                            echo "<script>alert('Login Successful');</script>";
                            echo '<script>window.location.href = "../SHomepage.php"</script>';
                        }
                    }
                } else {
                    $error_message = "Invalid credentials";
                }
            } elseif ($idPrefix === 'LP') {
                $query2 = "SELECT * FROM lecturer WHERE unique_id = '$ID'";
                $result2 = mysqli_query($conn, $query2);

                if (mysqli_num_rows($result2) > 0) {
                    $lecturerRow = mysqli_fetch_assoc($result2);

                    if ($lecturerRow['status'] === 'inactive') {
                        $error_message = "User is inactive.";
                    } else {
                        $status = "Active now";
                        $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = '{$row['unique_id']}'");
                        if ($sql2) {
                            $_SESSION['unique_id'] = $row['unique_id'];
                            echo "<script>alert('Login Successful');</script>";
                            echo '<script>window.location.href = "../LHomepage.php"</script>';
                        }
                    }
                } else {
                    $error_message = "Invalid credentials";
                }
            } elseif ($idPrefix === 'AP') {
                $query3 = "SELECT * FROM admin WHERE unique_id = '$ID'";
                $result3 = mysqli_query($conn, $query3);

                if (mysqli_num_rows($result3) > 0) {
                    $adminRow = mysqli_fetch_assoc($result3);

                    if ($adminRow['status'] === 'inactive') {
                        $error_message = "User is inactive.";
                    } else {
                        $status = "Active now";
                        $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = '{$row['unique_id']}'");
                        if ($sql2) {
                            $_SESSION['unique_id'] = $row['unique_id'];
                            echo "<script>alert('Login Successful');</script>";
                            echo '<script>window.location.href = "../AHomepage.php"</script>';
                        }
                    }
                } else {
                    $error_message = "Invalid credentials";
                }
            } else {
                $error_message = "Invalid credentials";
            }
        } else {
            $error_message = "Invalid credentials";
        }
    } else {
        $error_message = "Invalid credentials";
    }

    if (!empty($error_message)) {
        echo "<script>alert('" . $error_message . "');</script>";
        echo '<script>window.location.href="../login.php";</script>';
    }

} else {
    echo "<script>alert('" . $error_message . "');</script>";
    echo '<script>window.location.href="../login.php";</script>';
}

?>

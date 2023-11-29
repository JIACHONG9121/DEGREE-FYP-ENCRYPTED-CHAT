<?php
session_start();
include_once "BackEnd/connection.php";

if (isset($_SESSION['unique_id']) && isset($_GET['user_id'])) {
    $viewer_id = $_SESSION['unique_id'];
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

    $viewer_role = (strpos($viewer_id, "TP") === 0) ? "Student" : (
        (strpos($viewer_id, "LP") === 0) ? "Lecturer" : (
            (strpos($viewer_id, "AP") === 0) ? "Admin" : ""
        )
    );

    $sql = "
        SELECT 'Student' AS role, unique_id, fname, lname, img, email, phonenumber, status FROM student
        WHERE unique_id = '{$user_id}'
        UNION
        SELECT 'Lecturer' AS role, unique_id, fname, lname, img, email, phonenumber, status FROM lecturer
        WHERE unique_id = '{$user_id}'
        UNION
        SELECT 'Admin' AS role, unique_id, fname, lname, img, email, phonenumber, status FROM admin
        WHERE unique_id = '{$user_id}';
    ";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        $user_data = mysqli_fetch_assoc($query);

        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <title>Edit User</title>
        </head>
        <style>
            .user-profile {
                text-align: center;
                padding: 100px;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
            }

            .user-profile img {
                height: 150px;
                width: 150px;
                border-radius: 50%;
                margin-bottom: 20px;
                border: 2px solid #333;
            }

            .Uinfo {
                margin-bottom: 20px;
            }

            .update-button {
                background-color: #007BFF;
                color: #fff;
                padding: 10px 20px;
                margin: 0 10px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                text-decoration: none;
            }

            .update-button:hover {
                background-color: #0056b3;
            }
        </style>
        <?php
        include_once "Backlast.php";
        ?>

        <body>
            <div class="user-profile">
                <img src="BackEnd/images/<?php echo $user_data['img']; ?>" alt="">
                <p>
                    <?php echo $user_data['role']; ?>
                </p>
                <div class="Uinfo">
                    Role:
                    <?php echo $user_data['role']; ?><br><br>
                    UserID:
                    <?php echo $user_data['unique_id']; ?><br><br>
                    Name:
                    <?php echo $user_data['fname'] . " " . $user_data['lname']; ?><br><br>
                    Email:
                    <?php echo $user_data['email']; ?><br><br>
                    Phone Number:
                    <?php echo $user_data['phonenumber']; ?><br><br>
                    Status:
                    <form method="POST" action="BackEnd/update_users.php?user_id=<?php echo $user_data['unique_id']; ?>">
                        <select name="status">
                            <option value="active" <?php if ($user_data['status'] == 'active')
                                echo 'selected'; ?>>active</option>
                            <option value="inactive" <?php if ($user_data['status'] == 'inactive')
                                echo 'selected'; ?>>inactive
                            </option>
                        </select><br><br>
                        <input type="submit" value="Update User" class="update-button">
                    </form>
                </div>
            </div>
        </body>
        </html>

        <?php
    } else {
        echo "User not found.";
    }
} else {
    header("location: login.php");
}
?>

<?php
session_start();
include_once "BackEnd/connection.php";

if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit();
}

    include_once "Backlast.php"; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        .id-card {
            display: flex;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 100px;
            padding: 100px;
        }

        .user-photo {
            flex: 1;
        }

        .user-photo img {
            width: 40%;
            border-radius: 5px;
        }


        .user-info {
            flex: 1;
            padding-left: 20px;
        }

        .user-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .user-id {
            font-size: 14px;
            color: #888;
            margin-bottom: 10px;
        }

        .user-details {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="includeH">
        <?php
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

            $sql = "SELECT * FROM $table WHERE unique_id = '$unique_id'";
            $query = mysqli_query($conn, $sql);

            if (mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_assoc($query);
                ?>

                <div class="id-card">
                    <div class="user-photo">
                        <img src="BackEnd/images/<?php echo $row['img']; ?>" alt="User Photo">
                    </div>
                    <div class="user-info">
                        <div class="user-name">
                            <?php echo $row['fname'] . ' ' . $row['lname']; ?>
                        </div>
                        <div class="user-id">
                            <?php echo $row['unique_id']; ?>
                        </div>
                        <div class="user-details">

                            Email: <?php echo $row['email']; ?><br><br>
                            Phone: <?php echo $row['phonenumber']; ?><br><br>
                            Address: <?php echo $row['address']; ?><br><br>
                            <?php if (strpos($unique_id, "TP") === 0): echo "Intakecode: " . $row['intakecode']; endif; ?><br><br>
                        </div>
                    </div>
                </div>

                <?php
            }
        }
        ?>
    </div>
</body>
</html>

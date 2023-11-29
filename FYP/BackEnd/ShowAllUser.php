<?php
            session_start();
            include_once "connection.php";
            $outgoing_id = $_SESSION['unique_id'];

            $sql = "
            (SELECT 'Student' AS role, unique_id, fname, lname, img FROM student WHERE NOT unique_id = '{$outgoing_id}')
            UNION
            (SELECT 'Lecturer' AS role, unique_id, fname, lname, img FROM lecturer WHERE NOT unique_id = '{$outgoing_id}')
            UNION
            (SELECT 'Admin' AS role, unique_id, fname, lname, img FROM admin WHERE NOT unique_id = '{$outgoing_id}')
            ORDER BY role, fname, lname, img;
        ";

            $query = mysqli_query($conn, $sql);
            $output = "";

            if (mysqli_num_rows($query) == 0) {
                $output .= "No users are available to chat";
            } elseif (mysqli_num_rows($query) > 0) {
                include_once "userlist.php";
            }
            echo $output;
            ?>
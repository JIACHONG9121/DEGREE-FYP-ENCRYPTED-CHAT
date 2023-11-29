<?php
while ($row = mysqli_fetch_assoc($query)) {
    $output .= 
    '<div class="user-container">
    <a href="viewprofile.php?user_id=' . $row['unique_id'] . '">
    <div class="role">
    <p>' . $row['role'] . '</p> 
        <div class="content">
            <img src="BackEnd/images/' . $row['img'] . '" alt="">

            <div class="details">
                <span>' . $row['fname'] . " " . $row['lname'] . '</span>
                <span>' . $row['unique_id'] . '</span>
                
            </div>
            </div>
        </div>
        </div>
    </a>';
}

?>
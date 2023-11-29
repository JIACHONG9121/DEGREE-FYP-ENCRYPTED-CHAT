<?php

$uniqueUsers = [];


$usersWithMessages = "";
$usersWithoutMessages = "";

while($row = mysqli_fetch_assoc($query)){
    
    if (!isset($uniqueUsers[$row['unique_id']])) {
        $uniqueUsers[$row['unique_id']] = true;

        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = '{$row['unique_id']}'
            OR outgoing_msg_id = '{$row['unique_id']}') AND (outgoing_msg_id = '{$outgoing_id}'
            OR incoming_msg_id = '{$outgoing_id}') ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        $algorithm = "AES-256-CBC";

        if(mysqli_num_rows($query2) > 0) {
            $encrypted_message = $row2['msg'];
            $msg_key = hex2bin($row2['message_key']);
            $msg_iv = hex2bin($row2['message_iv']);

            $AES_message = openssl_decrypt($encrypted_message, $algorithm, $msg_key, 0, $msg_iv);
            $decrypted_message = base64_decode($AES_message);
            $encryptedFileContents = $row2['file'];
            $decryptedFileContentsBase64 = base64_decode($encryptedFileContents);
            $decodedFilename = base64_decode($row2['file']);
        }

        $msg = "";
        $file = "";

        if (!empty($decrypted_message)) {
            if (strlen($decrypted_message) > 70) {
                $msg = substr($decrypted_message, 0, 70) . '...';
            } else {
                $msg = $decrypted_message;
            }
        } elseif (!empty($decodedFilename)) {
            $file = $decodedFilename;
            $file = strlen($file) > 70 ? substr($file, 0, 70) . '...' : $file;
        }

        if (isset($row2['outgoing_msg_id'])) {
            $you = ($outgoing_id == $row2['outgoing_msg_id']) ? "You: " : "";
        } else {
            $you = "";
        }

        if (!empty($row2['msg']) || !empty($row['file'])) {
            $output_message = '<b>' . htmlspecialchars($you . $msg . $file) . '</b>';
        } else {
            $output_message = '<i>No messages currently, once you send and receive, it will appear</i>';
        }

        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
        ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";

        // Check if the user has messages and add them to the appropriate variable
        if (!empty($row2['msg']) || !empty($row['file'])) {
            $usersWithMessages .= '<a href="chat.php?user_id='. $row['unique_id'] .'">
                <div class="content">
                <img src="BackEnd/images/'. $row['img'] .'" alt="">
                <div class="details">
                <span>'. $row['fname']. " " . $row['lname'] .' <span class="status-dot '. $offline .'"><i class="fas fa-circle"></i></span></span>
                <p>' . $output_message . '</p>
                </div>
                </div>
            </a>';
        } else {
            // If the user has no messages, add them to the usersWithoutMessages variable
            $usersWithoutMessages .= '<a href="chat.php?user_id='. $row['unique_id'] .'">
                <div class="content">
                <img src="BackEnd/images/'. $row['img'] .'" alt="">
                <div class="details">
                <span>'. $row['fname']. " " . $row['lname'] .' <span class="status-dot '. $offline .'"><i class="fas fa-circle"></i></span></span>
                <p>' . $output_message . '</p>
                </div>
                </div>
            </a>';
        }
    }
}


$output = $usersWithMessages . $usersWithoutMessages;

?>

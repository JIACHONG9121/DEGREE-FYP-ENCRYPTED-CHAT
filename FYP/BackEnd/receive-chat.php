<?php
session_start();
function makeLinksClickable($message) {
    return preg_replace('/(http[s]?:\/\/[^\s]+)/', '<a href="$1" target="_blank">$1</a>', $message);
}

if (isset($_SESSION['unique_id'])) {
    include_once "connection.php";
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";

    $algorithm = "AES-256-CBC";

    $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
            WHERE (outgoing_msg_id = '{$outgoing_id}' AND incoming_msg_id = '{$incoming_id}')
            OR (outgoing_msg_id = '{$incoming_id}' AND incoming_msg_id = '{$outgoing_id}') ORDER BY msg_id";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $encrypted_message = $row['msg'];
            $msg_key = hex2bin($row['message_key']);
            $msg_iv = hex2bin($row['message_iv']);
            
            $AES_message = openssl_decrypt($encrypted_message, $algorithm, $msg_key, 0, $msg_iv);
            $decrypted_message =  base64_decode($AES_message);

            $decrypted_message_with_links = makeLinksClickable($decrypted_message);

            $encryptedFileContents = $row['file'];
            $timestamp = $row['msg_timestamp'];
            $decryptedFileContentsBase64 = base64_decode($encryptedFileContents);
            $decodedFilename = base64_decode($row['file']);
            if ($row['outgoing_msg_id'] === $outgoing_id) {
                $output .= '<div class="chat outgoing">
                            <div class="details">';

                            if (!empty($decrypted_message_with_links)) {                           
                                if (strpos($decrypted_message_with_links, '<') !== false) {
                                    $output .= '<p>' . $decrypted_message_with_links . '</p>';
                                } else {
                                    $output .= '<p>' . $decrypted_message_with_links . '</p>';
                                }
                            }

                if (!empty($decryptedFileContentsBase64)) {
                    $fileExtension = pathinfo($decodedFilename, PATHINFO_EXTENSION);
                    $fileDownloadLink = 'BackEnd/chatfile/' . $decodedFilename; 
                
                    if (in_array($fileExtension, ['png', 'jpg', 'jpeg'])) {
                        $output .= '<p><img class="chat-image clickable-image" src="BackEnd/chatfile/' . $decodedFilename . '" alt="Image" width="200" onclick="openImageInModal(\'BackEnd/chatfile/' . $decodedFilename . '\')"></p>';
                    } else {
                        $output .= '<p><a href="' . $fileDownloadLink . '" target="_blank" download style="color: black; text-decoration: none;">' . $decodedFilename . '</a></p>';
                    }
                    
                }

                $output .= '<li>' . $timestamp . '</li>
                            </div>
                            </div>';
            } else {
                $output .= '<div class="chat incoming">
                    <div class="image-container">
                        <img class="profile-image" src="BackEnd/images/' . $row['img'] . '" alt="">
                    </div>
                    <div class="details">';
            
                    if (!empty($decrypted_message_with_links)) {                          
                        if (strpos($decrypted_message_with_links, '<script>') !== false) {
                            $output .= '<p>' . htmlspecialchars($decrypted_message_with_links) . '</p>';
                        } else {
                            $output .= '<p>' . $decrypted_message_with_links . '</p>';
                        }
                    }
            
                if (!empty($decryptedFileContentsBase64)) {
                    $fileExtension = pathinfo($decodedFilename, PATHINFO_EXTENSION);
                    if (in_array($fileExtension, ['png', 'jpg', 'jpeg'])) {
                        $output .= '<p><img class="chat-image clickable-image" src="BackEnd/chatfile/' . $decodedFilename . '" alt="Image" width="200" onclick="openImageInModal(\'BackEnd/chatfile/' . $decodedFilename . '\')"></p>';
                    } else {
                        $output .= '<p><a href="BackEnd/chatfile/' . $decodedFilename . '" target="_blank">' . $decodedFilename . '</a></p>';
                    }
                }

                $output .= '<li>' . $timestamp . '</li>
                            </div>
                            </div>';
            }
        }
    } else {
        $output .= '<div class="text">No messages are available now.....</div>';
    }
    echo $output;
} else {
    header("location: ../login.php");
}


?>

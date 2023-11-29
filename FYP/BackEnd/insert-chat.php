<?php
session_start();
if(isset($_SESSION['unique_id'])){
    include_once "connection.php";
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    
    $message = ""; 
    $file = ""; 
    
    $messageKey = bin2hex(openssl_random_pseudo_bytes(32)); 
    $messageIV = bin2hex(openssl_random_pseudo_bytes(16)); 
    
    $Algorithm = "AES-256-CBC";
    
    if(isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $uploadDirectory = 'chatfile/';
        
        $originalFilename = basename($_FILES['attachment']['name']);
        $fileExtension = strtolower(pathinfo($originalFilename, PATHINFO_EXTENSION));

        $allowedExtensions = array("png", "jpeg", "jpg", "docx", "pdf");

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Invalid file type. Allowed file types are: png, jpeg, jpg, docx, pdf";
            exit();
        }

        $encodedFilename = base64_encode($originalFilename);
    
        $uploadPath = $uploadDirectory . $originalFilename;
    
        if(move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadPath)) {
            $file = $encodedFilename; 
            
            $fileContents = file_get_contents($uploadPath);

            $fileContentsBase64 = base64_encode($fileContents);
        } else {
            echo "File upload failed. Error: " . $_FILES['attachment']['error'];
            exit();
        }
    }
    
    $raw_message = mysqli_real_escape_string($conn, $_POST['message']); 
    $encryptedMessage = base64_encode($raw_message);
    $message = openssl_encrypt($encryptedMessage, $Algorithm, hex2bin($messageKey), 0, hex2bin($messageIV));

    
    if(!empty($message) || !empty($file)){
        $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, message_key, message_iv, file, msg_timestamp)
                VALUES ('{$incoming_id}', '{$outgoing_id}', '{$message}', '{$messageKey}', '{$messageIV}', '{$file}', NOW())";
                
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

        echo "Message inserted successfully.";
    }
} else {
    header("location: ../login.php");
}


?>

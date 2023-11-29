<!DOCTYPE html>
<html>
<?php
    include_once "Backlast.php"; 
?>
<head>
    <title>Change Password</title>
    <style>

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
         .form-container {
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .password-input {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .eye-icon {
            cursor: pointer;
            margin-left: -30px;
            position: relative;
            top: 5px;
        }

        .generate-password-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
</head>
    </style>
</head>

<body>
<div class="form-container">
    <h2>Change Password</h2>
    <form action="BackEnd/changepassword.php" method="POST">
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" id="current_password" class="password-input" required>
        <span class="eye-icon" onclick="togglePasswordVisibility('current_password')">
            <i class="fa fa-eye" aria-hidden="true"></i>
        </span><br>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" class="password-input" required>
        <span class="eye-icon" onclick="togglePasswordVisibility('new_password')">
            <i class="fa fa-eye" aria-hidden="true"></i>
        </span><br>


        <button type="button" onclick="generateComplexPassword()" class="generate-password-button">Generate Password</button>

        <input type="submit" class="generate-password-button" name="change_password" value="Change Password">
    </form>

    </div>
    <script>
        function togglePasswordVisibility(inputId) {
            var passwordInput = document.getElementById(inputId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }


        function generateComplexPassword() {
            var passwordInput = document.getElementById("new_password");
            var length = 12; 
            var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-+=<>?";

            var newPassword = "";
            for (var i = 0; i < length; i++) {
                var randomIndex = Math.floor(Math.random() * charset.length);
                newPassword += charset.charAt(randomIndex);
            }


            passwordInput.value = newPassword;
        }
    </script>
</body>

</html>

<!DOCTYPE html>
<html>

<head>
    <title>Login To APSPACE</title>
    <?php include_once "HeaderWL.php"; ?>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form class="login-form" action="BackEnd/login.php" method="POST" enctype="multipart/form-data"
            autocomplete="off">
            <label for="username">User ID:</label>
            <input type="text" id="ID" name="ID" placeholder="Enter your ID TP/LP/AP" required><br>

            <label for="password">Password:</label>
            <div class="password-input">
                <input type="password" id="password" name="password" required>
                <span class="eye-icon" onclick="togglePasswordVisibility()"><i class="fa fa-eye"
                        aria-hidden="true"></i></span>
            </div>

            <input type="submit" value="Login">
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</body>

</html>
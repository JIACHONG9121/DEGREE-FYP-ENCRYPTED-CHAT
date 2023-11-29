<?php include_once "AHeader.php"; ?>

<body>

    <div class="register-container">
        <section class="formReg">
            <h1>Admin Register</h1>


            <form class="register-form" action="BackEnd/addUABE.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="input">
                    <label class="text">First Name</label>
                    <input type="text" name="fname" placeholder="First name" required>
                </div>
                <div class="input">
                    <label class="text">Last Name</label>
                    <input type="text" name="lname" placeholder="Last name" required>
                </div>

                <div class="input">
                    <label class="text">Address</label>
                    <textarea type="text" name="Saddress" rows="4" placeholder="Address" required></textarea>
                </div>

                <div class="input">
                    <label class="text">Phone number</label>
                    <input type="text" name="phonenumber" placeholder="EG: 0127878787" required>
                </div>
                <div class="input">
                    <label class="text">Gender</label>
                    <select name="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="input">
                    <label class="text">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter new password" required>
                </div>
                <div class="show-password-container">
                    <input type="checkbox" id="showPassword" onchange="togglePasswordVisibility()">
                    <label for="showPassword">Show Password</label>
                </div>
                <div class="input">
                    <label class="image">Select Image</label>
                    <div class="imagec">
                        <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
                    </div>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Register">
                </div>
            </form>

        </section>
</div>

</body>

</html>

<script>

    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var showPasswordCheckbox = document.getElementById("showPassword");

        if (showPasswordCheckbox.checked) {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
</script>
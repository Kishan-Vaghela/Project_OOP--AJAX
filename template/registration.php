<?php
include "../classes/register.php";

new Register();
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="../css/register_css.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#FormID').submit(function (event) {
            event.preventDefault(); 
            if (validateForm()) {
                var form = $(this);
                var formData = new FormData(form[0]);
                $.ajax({
                    type: 'POST',
                    url: '../classes/registration.php', 
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#error_para').html(response);
                    }
                });
            }
        });

        function validateForm() {
            var error = "";
            var firstname = $('#firstname').val();
            var lastname = $('#lastname').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var phoneno = $('#phoneno').val();
            var address = $('#address').val();

            if (firstname == "" || lastname == "" || email == "" || password == "" || phoneno == "" || address == "") {
                $('#error_para').html("Please fill out all the details");
                return false;
            }

            if (email.indexOf('@') == -1) {
                $('#error_para').html("Invalid email");
                return false;
            }

            if (password.length < 6) {
                $('#error_para').html("Password must be at least 6 characters long");
                return false;
            }

            if (isNaN(phoneno) || phoneno.length != 10) {
                $('#error_para').html("Invalid phone number");
                return false;
            }

            return true;
        }
    });
    </script>
</head>
<body>
    <div class="container">
        <fieldset>
            <legend>Registration Form</legend>
            <form id="FormID" method="post" action="">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname"><br><br>
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname"><br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"><br><br>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email"><br><br>
                <label for="phoneno">Phone Number:</label>
                <input type="text" id="phoneno" name="phoneno" minlength="10" maxlength="10"><br><br>
                <label for="address">Address:</label>
                <textarea id="address" name="address"></textarea><br><br>
                <input type="submit" name="submit" value="Register">
                <br><br>
                <div class="button-container">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </div>
            </form>
            <p id='error_para'></p>
        </fieldset>
    </div>
</body>
</html>

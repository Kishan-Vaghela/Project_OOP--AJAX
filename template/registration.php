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


                if (validateForm()) {
                    var form = $(this);
                    var formData = new FormData(form[0]);

                    $.ajax({
                        type: 'POST',
                        url: '../classes/register.php',
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
                var firstname = document.getElementById('firstname').value;
                var lastname = document.getElementById('lastname').value;
                var email = document.getElementById('email').value;
                var password = document.getElementById('password').value;
                var phoneno = document.getElementById('phoneno').value;
                var address = document.getElementById('address').value;

                if (firstname == "" || lastname == "" || email == "" || password == "" || phoneno == "" || address == "") {
                    error = alert("Please fill out all the details");
                    document.getElementById("error_para").innerHTML = "Please fill out all the details";
                    return false;
                }

                if (email.indexOf('@') == -1) {
                    error = alert("Invalid email");
                    document.getElementById("error_para").innerHTML = "Invalid email";
                    return false;
                }

                if (password.length < 6) {
                    error = alert("Password must be at least 6 characters long");
                    document.getElementById("error_para").innerHTML = "Password must be at least 6 characters long";
                    return false;
                }

                if (isNaN(phoneno) || phoneno.length != 10) {
                    error = alert("Invalid phone number");
                    document.getElementById("error_para").innerHTML = "Invalid phone number ( The Phone number should be digits only and 10 digits long )";
                    return false;
                    exit();
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

            <form id="FormID" method="post" action="" onsubmit="validateForm()">
            <div id="error_message">
                <?php
                if (isset($_SESSION['error_message'])) {
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']);
                }
                ?>
            </div>
            <br>
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname"><br>
                <br>
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname"><br>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="pass"><br>
                <br>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email"><br>
                <br>
                <label for="phoneno">Phone Number:</label>
                <input type="text" id="phoneno" name="phoneno" minlength="10" maxlength="10"><br>
                <br>
                <label for="address">Address:</label>
                <textarea id="address" name="address"></textarea><br>
                <br>
                <input type="submit" name="submit" value="Register">
                <br>
                <div class="button-container">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </div><br>
            </form>


            
        </fieldset>
    </div>
</body>

</html>
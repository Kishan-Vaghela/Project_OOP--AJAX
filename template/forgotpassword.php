<?php
include "../classes/forgot_password.php";
$forgot =  new ForgotPassword;
$forgot -> Password();


?>


<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../css/forgotpassword.css">
</head>
<body>
    <fieldset>
        <legend>Forgot Password</legend>
        <form action="" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <input type="submit" name="forgot_password" value="Send Verification Code">
        </form>
        <div>
            <p>Remember your password? <a href="../template/login.php">Log in</a></p>
        </div>
    </fieldset>
</body>
</html>
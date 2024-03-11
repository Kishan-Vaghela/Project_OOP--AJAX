
<?php
include "../classes/login.php";
new login();
?>


<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <fieldset>
        <legend>LOGIN</legend>
        <img src="../css/Login.jpg" alt="Login Image" class="login-image">
        <form action="" method="post">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required><br>
            <label for="password">Password:</label>
            <input type="password" id="pass" name="pass" required><br>
            <input type="submit" name="login" value="Login">
        </form>
        <div>
            <p>Don't have an account? <a href="../template/registration.php">Create New Account</a></p>
            <p>Forgot Password? <a href="../template/forgotpassword.php">Forgot Password</a></p>
        </div>
    </fieldset>
</body>

</html>

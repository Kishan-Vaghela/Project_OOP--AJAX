<?php
include "../classes/reset_password.php";
new ResetPassword();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../css/resetpassword.css">
</head>
<body>
    <h2>Reset Password</h2>
    <form method="post" action="">
        <label>New Password:</label><br>
        <input type="password" name="newpassword" required><br><br>
        <button type="submit" name="submit">Reset Password</button>
    </form>
</body>
</html>

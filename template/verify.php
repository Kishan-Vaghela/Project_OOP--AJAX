<?php
include "../classes/verify_password.php";
$vp = new VerifyPassword();
$vp->verify();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Code</title>
    <link rel="stylesheet" href="../css/verify.css">
</head>
<body>
    <h2>Verify Code</h2>
    <form method="post" action="">
        <label>Verification Code:</label><br>
        <input type="text" name="verification_code" required><br><br>
        <button type="submit" name = "submit">Verify</button>
    </form>
</body>
</html>
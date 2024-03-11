<?php
include "../classes/edit_user.php";
$edit = new UserEdit();
$edit->updateRecord();
$edit->goBack();
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" href="../css/user_edit.css">
    <title>User Update Form</title>
</head>

<body>
    <h2 style="text-align: center;">User Update Form</h2>
    <form action="" method="POST">
        <?php
        $userData = $edit->displayForm();
        if ($userData) {
            extract($userData);
            ?>
            <fieldset>
                <legend>Personal Information </legend>
                First Name :<br>
                <input type="text" name="firstname" value="<?php echo $firstname; ?> ">
                <input type="hidden" name="id" value="<?php echo $id; ?>"><br>
                Last Name :<br>
                <input type="text" name="lastname" value="<?php echo $lastname; ?> "><br>
                Email:<br>
                <input type="email" name="email" value="<?php echo $email; ?> "><br>
                Password:<br>
                <input type="password" name="pass" value="<?php echo $password; ?> "><br>
                Address :
                <textarea id="address" name="address"><?php echo $address; ?></textarea><br>
                <br><br>
                <input type="submit" name="update" value="Update">
                <input type="submit" name="Back" value="Back">
            </fieldset>
            <?php
        } else {
            header("Location: ../template/user.php");
            exit;
        }
        ?>
    </form>
</body>

</html>

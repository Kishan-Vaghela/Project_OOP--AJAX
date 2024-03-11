<?php

include '../classes/admin_edit.php';

$editAdmin = new EditAdmin();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Update Form</title>

    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/admin_edit.css">
    <style>
        .inactive-text {
            display: none;
        }

        .toggle:checked+.slider .inactive-text {
            display: block;
        }

        .toggle:checked+.slider .active-text {
            display: none;
        }
    </style>

</head>

<body>

    <?php
    $userData = $editAdmin->displayForm();

    if ($userData) {
        $first_name = $userData['firstname'];
        $lastname = $userData['lastname'];
        $email = $userData['email'];
        $password = $userData['password'];
        $address = $userData['address'];
        $status = isset($userData['status']);
        $id = $userData['id'];
        ?>
        <h2>User Update Form</h2>
        <form action="" method="POST">
            <fieldset>
                <legend>Personal Information</legend>
                First Name:<br>
                <input type="text" name="firstname" value="<?php echo $first_name; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>"><br>
                Last Name:<br>
                <input type="text" name="lastname" value="<?php echo $lastname; ?>"><br>
                Email:<br>
                <input type="email" name="email" value="<?php echo $email; ?>"><br>
                Password:<br>
                <input type="password" name="pass" value="<?php echo $password; ?>"><br>
                Address:<br>
                <textarea name="address" required><?php echo $address; ?></textarea><br>
                <br>
                <label class="switch">
                    <input type="checkbox" name="toggle" class="toggle" <?php if ($status == 1) echo "checked" ?>>
                    <span class="slider round"></span>
                </label>
                <br><br>
                <span class="inactive-text">Inactive</span>
                <span class="active-text">Active</span><br><br>
                <input type="submit" name="update" value="Update">
                <input type="submit" name="Back" value="Back">
            </fieldset>
        </form>
        <?php
    } else {
        echo "User not found.";
    }
    ?>

</body>

</html>
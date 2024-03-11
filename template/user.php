<?php
include "../classes/user_dashboard.php";
$user = new UserDashboard();
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/user.css">


</head>

<body>
    <?php include "../classes/navbar.php" ?>
    <div class="container mt-5">
    <?php
        $user->Message(); 
        ?>
        <h2 class="mb-4">User Dashboard</h2>
        <h3> Hey! &#128075; Your Personal Information</h3><br>
       
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $user->User();
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $row['firstname']; ?>
                        </td>
                        <td>
                            <?php echo $row['lastname']; ?>
                        </td>
                        <td>
                            <?php echo $row['email']; ?>
                        </td>
                        <td>
                            <?php echo $row['phone']; ?>
                        </td>
                        <td>
                            <?php echo $row['address']; ?>
                        </td>
                        <td>
                            <a class="btn btn-info" href="../template/edit.php?id=<?php echo $row['id']; ?>">Edit</a>&nbsp;
                        </td>
                    </tr>
                    <?php
                }
                if (mysqli_num_rows($result) == 0) {
                    echo "<tr><td colspan='6'>No user data found</td></tr>";
                }
                ?>

            </tbody>
        </table>
        <a href="../classes/logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>

</html>
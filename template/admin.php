<?php
include "../classes/admin_dashboard.php";
$admin = new AdminDashboard();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4 d-flex justify-content-center">Admin Dashboard</h2>
        <h3> Hey! &#128075; Welcome to Admin Dashboard </h3><br>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Address</th>
                    <th>Actions</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                $result = $admin->fetchUser();
                while ($row = $result->fetch_array()) {
                ?>
                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo $row['firstname']; ?></td>
                        <td><?php echo $row['lastname']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td>
                            <a class="btn btn-info" href="edit_admin.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a class="btn btn-danger" href="../classes/delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                        <td><?php echo ($row['status'] == 1) ? "Active" : "Inactive"; ?></td>
                    </tr>
                <?php
                    $counter++;
                }
                ?>
            </tbody>
        </table>
        <a href="../classes/logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>

</html>

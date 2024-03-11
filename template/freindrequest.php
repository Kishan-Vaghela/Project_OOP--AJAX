<?php
include "../classes/friend_request.php";

$friendRequests = $friendRequests->request();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friend Requests</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   
</head>

<body>

    <?php include "../classes/navbar.php" ?>
    <div class="container">
        <h2>Friend Requests</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Sender Email</th>
                    <th>Status</th>
                    <th>Requests</th>
                </tr>
            </thead>
            <tbody>
                <?php
               if (mysqli_num_rows($friendRequests) > 0) {
                   while ($row = mysqli_fetch_assoc($friendRequests)) {
                       echo "<tr>";
                       echo "<td>" . $row["sender_email"] . "</td>";
                       echo "<td>" . $row["status"] . "</td>";
                       echo "<td>";
               
                       if ($row["status"] === "accepted") {
                           echo "You are already friends";
                       } else {
                           echo "<form method='post' action='../classes/friend_request.php'>";
                           echo "<input type='hidden' name='sender_email' value='" . $row["sender_email"] . "'>";
                           echo "<button type='submit' class='btn btn-info' name='accept'>Accept</button>";
                           echo "</form>";
                            
                           echo "<form method='post' action='../classes/friend_request.php'>";
                           echo "<input type='hidden' name='sender_email' value='" . $row["sender_email"] . "'>";
                           echo "<button type='submit' class='btn btn-danger' name='reject'>Reject</button>";
                           echo "</form>";
                       }
               
                       echo "</td>";
                       echo "</tr>";
                   }
               } else {
                   echo "<tr><td colspan='3'>You have no friend requests.</td></tr>";
               }
               ?>
               
            </tbody>
        </table>
    </div>

   
</body>

</html>

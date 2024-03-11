<?php
include "../classes/friendlist.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <?php include "../classes/navbar.php" ?>
    <br>
    <div class="container">
        <h2>Friends</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Friend Email</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Chat</th>
                    <th scope="col">Unread Messages</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $_SESSION['frnd'] = "";
                $friendList = new FriendList();
                $user_Email = $_SESSION['member_details']['email'];

                $result = $friendList->getFriendList();

                while ($row = $friendList->fetchAssoc($result)) {
                    $friendEmail = $row['sender_email'];
                    $count = $friendList->getUnreadMessagesCount($user_Email, $friendEmail);

                    $urow = $friendList->getUserDetails($friendEmail);

                    echo "<tr>
                            <td>" . $row['sender_email'] . "</td>
                            <td>" . $urow['firstname'] . "</td>
                            <td>" . $urow['lastname'] . "</td>
                            <td>" . $urow['phone'] . "</td>
                            <td>
                                <form action='chat.php' method='post'>
                                    <input type='hidden' name='friendEmail' value='" . $friendEmail . "'>
                                    <button type='submit' class='btn btn-primary' name='chat'>Chat</button>
                                </form>
                            </td>
                            <td>" . $count . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

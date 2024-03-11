<?php
include "../classes/search_class.php";

$searchObj = new search();
$searchObj->FriendRequest();
$searchObj->CancelRequest();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .search-form {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 15px;
        }

        .search-form .form-control {
            margin-left: 10px;
        }

        .user-result {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ddd;
        }
    </style>
  <script>
  $(document).ready(function ($) {
    $("#search-btn").on("click", function () {
        var search = $('#search').val().trim(); 
        if (search !== "") {
            $.ajax({
                type: 'POST',
                url: 'searchajax.php',
                data: {action: 'search', search: search },
                success: function (data) {
                    console.log(data);
                    $("#table").html(data);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            
            alert("Please enter freind Email address .");
        }
    });
});



</script>

</head>

<body>
    <?php include "../classes/navbar.php"; ?>

    <br>
    <div class="container">
        <h2>Existing Users</h2>
        <div class="row">
            <div class="col-lg-6 offset-lg-6">
                <form class="form-inline my-2 my-lg-0 search-form">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search by Email" aria-label="Search"
                        name="search_email" id="search">
                    <button id="search-btn" name ="search" class="btn btn-outline-success my-2 my-sm-0" type="button">Search</button>
                </form>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Request</th>
                </tr>
            </thead>
            <tbody id="table">
                <?php
                $result = $searchObj->searchUsers();
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['firstname'] . '</td>';
                    echo '<td>' . $row['lastname'] . '</td>';
                    echo '<td>' . $row['email'] . '</td>';
                    echo '<td>' . $row['phone'] . '</td>';
                    echo '<td>';

                    $email = $_SESSION['member_details']['email'];
                    $femail = $row['email'];
                    $queryc = "SELECT * FROM friend_requests WHERE sender_email = '$email' AND receiver_email = '$femail'";
                    $rcheck = mysqli_query($searchObj->get_connection(), $queryc);
                    $qcheck = mysqli_fetch_array($rcheck, MYSQLI_ASSOC);

                    if (empty($qcheck)) {
                        echo '<form action="" method="POST">';
                        echo '<button name="friend_req" class="btn btn-info" value="' . $femail . '">Friend Request</button>';
                        echo '</form>';
                    } elseif ($qcheck['status'] === 'pending') {
                        echo "Request Already Sent &nbsp;&nbsp;";
                        echo '<form action="" method="POST">';
                        echo '<button name="cancel_req" class="btn btn-danger" value="' . $femail . '">Cancel Request</button>';
                        echo '</form>';
                    } elseif ($qcheck['status'] === 'accepted') {
                        echo "Request Accepted!";
                    }

                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

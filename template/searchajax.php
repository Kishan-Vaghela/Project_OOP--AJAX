<?php
include "../classes/db.php";
session_start();

class SearchAjax extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function search()
    {
        if(isset($_POST['search']) && !empty($_POST['search'])) {
            $currentuser = $_SESSION['member_details']['email'];
            $search = $_POST['search'];
            $sql = "SELECT * FROM users WHERE email LIKE '$search%' ";
            $result = mysqli_query($this->get_connection(), $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                echo '<table class="table">';
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
                    $rcheck = mysqli_query($this->get_connection(), $queryc); 
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
                echo '</table>';
            } else {
                echo '<a href="#" class="list-group-item list-group-item-action">No results found</a>';
            }
        }}
    }


$search = new SearchAjax();

if (!empty($_POST) && isset($_POST['action']) && $_POST['action'] == 'search') {
    $search->search();
}
?>

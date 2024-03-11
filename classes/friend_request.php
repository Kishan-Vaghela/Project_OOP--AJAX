<?php
session_start();
include "db.php";


/**
 * FriendRequest Class
 * 
 * This class extends the Database class and is designed to handle friend requests between users.
 * It includes methods for retrieving, accepting, and rejecting friend requests.
 */
class FriendRequest extends Database
{
    /**
     * Constructor method
     * 
     * Initializes the Login class by checking if the user is logged in with the 'User' role.
     * Redirects to the login page if not. Calls the parent constructor to establish a database connection.
     *
     * @return void
     */
    public function __construct()
    {
        if (!isset($_SESSION['member_details']) || $_SESSION['member_details']['role'] !== 'User') {
            header("Location: ../template/login.php");
            exit();
        }
        parent::__construct();
    }

    /**
     * Request Function
     * 
     * Retrieves pending friend requests for the logged-in user from the database.
     *
     * @return mixed Returns the result of the SQL query.
     */
    public function request()
    {
        $user_Email = $_SESSION['member_details']['email'];
        $sql = "SELECT sender_email, status FROM friend_requests WHERE receiver_email = '$user_Email' AND status = 'pending'";
        $result = mysqli_query($this->get_connection(), $sql);
        return $result;
    }

    /**
     * AcceptFriendRequest Function
     * 
     * Accepts a friend request. Checks if the sender and receiver are not already friends before updating the status.
     * Redirects to the friends page after accepting the request.
     *
     * @param string $senderEmail The email of the friend request sender.
     * @param string $receiverEmail The email of the friend request receiver (logged-in user).
     *
     * @return void
     */
    public function acceptFriendRequest($senderEmail, $receiverEmail)
    {
       
        $checkSql = "SELECT * FROM friend_requests WHERE (sender_email = '$senderEmail' AND receiver_email = '$receiverEmail' AND status = 'accepted')";
        $checkResult = mysqli_query($this->get_connection(), $checkSql);

        if (mysqli_num_rows($checkResult) == 0) {
            $updateSql = "UPDATE friend_requests SET status = 'accepted' WHERE sender_email = '$senderEmail' AND receiver_email = '$receiverEmail'";
            $updateResult = mysqli_query($this->get_connection(), $updateSql);

            if ($updateResult) {
                $_SESSION['status'][$senderEmail] = 'accepted';
                header("Location: ../template/friends.php");
                unset($_SESSION['status'][$senderEmail]);
            } else {
                echo "Error updating friend request status.";
            }
        } else {
            echo "You are already friends!";
        }
    }

    /**
     * RejectRequest Function
     * 
     * Rejects a friend request. Deletes the friend request from the database.
     * Redirects to the friend request page after rejecting the request.
     *
     * @return void
     */
    public function rejectRequest()
    {
        if (isset($_POST['reject'])) {
            $senderEmail = $_POST['sender_email'];
            $sql = "DELETE FROM friend_requests WHERE sender_email = '$senderEmail' AND receiver_email = '" . $_SESSION['member_details']['email'] . "'";
            if (mysqli_query($this->get_connection(), $sql)) {
                header('Location:../template/freindrequest.php');
                exit();
            } else {
                echo "Failed to reject request. Please try again.";
            }
        }
    }
}

// Create an instance of the FriendRequest class
$friendHandler = new FriendRequest();

// Check if the 'accept' or 'reject' button is clicked in the POST request
if (isset($_POST['accept'])) {
    $senderEmail = $_POST['sender_email'];
    $receiverEmail = $_SESSION['member_details']['email'];
    $friendHandler->acceptFriendRequest($senderEmail, $receiverEmail);
} elseif (isset($_POST['reject'])) {
    $friendHandler->rejectRequest();
} 

// Create an instance of the FriendRequest class to retrieve friend requests
$friendRequests = new FriendRequest();
?>
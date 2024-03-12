<?php
include "db.php";
session_start();
/**
 * Search Class
 * 
 * This class extends the Database class and is designed to handle user search and friend requests.
 * It includes methods to search for users, send friend requests, cancel friend requests, and display search results.
 */

 class Search extends Database {
    /**
     * Constructor method
     * 
     * Initializes the Search class by calling the parent constructor to establish a database connection.
     * Checks if the user is logged in and has the 'User' role. Redirects to the login page if not.
     *
     * @return void
     */
    public function __construct() {
        if (!isset($_SESSION['member_details']) || $_SESSION['member_details']['role'] !== 'User') {
            header("Location: login.php");
            exit;
        }
        parent::__construct();
    }

    /**
     * searchUsers Method
     * 
     * Searches for users based on the provided search criteria, such as email.
     * Builds a SQL query and retrieves the search results from the database.
     *
     * @return mixed Result set from the database query.
     */
    public function searchUsers() {
        $currentuser = $_SESSION['member_details']['email'];
        $sql = "SELECT * FROM users WHERE role = 'User' AND email != '$currentuser'";

        if (isset($_POST['search_email']) && !empty($_POST['search_email'])) {
            $searchEmail = $_POST['search_email'];
            $sql .= " AND email = '$searchEmail'";
        }

        $result = mysqli_query($this->get_connection(), $sql);

        return $result;
    }

    /**
     * FriendRequest Method
     * 
     * Processes the submission of friend requests.
     * Checks if the requested friend's email is valid and if a friend request has not been sent previously.
     * Inserts a new friend request into the database if conditions are met.
     *
     * @return void
     */
    public function FriendRequest() {
        if (isset($_POST['friend_req'])) {
            $receiver = $_POST['friend_req'];
            $senderEmail = $_SESSION['member_details']['email'];
            $currentuser = $_SESSION['member_details']['email'];

            $check_r = "SELECT email FROM users WHERE email = '$receiver' AND email != '$currentuser'";
            $r_result = mysqli_query($this->get_connection(), $check_r);

            if ($r_result && mysqli_num_rows($r_result) > 0) {
                $receiverEmail = mysqli_fetch_assoc($r_result)['email'];

                $sql = "SELECT * FROM friend_requests WHERE sender_email = '$senderEmail' AND receiver_email = '$receiverEmail'";
                $friend_result = mysqli_query($this->get_connection(), $sql);

                if (!$friend_result || mysqli_num_rows($friend_result) == 0) {
                    $insert = "INSERT INTO friend_requests (sender_email, receiver_email) VALUES ('$senderEmail', '$receiverEmail')";
                    mysqli_query($this->get_connection(), $insert);
                }
            }
        }
    }

    /**
     * CancelRequest Method
     * 
     * Processes the cancellation of friend requests.
     * Deletes a friend request from the database if the request is still in the 'pending' status.
     *
     * @return void
     */
    public function CancelRequest() {
        if (isset($_POST['cancel_req'])) {
            $receiver = $_POST['cancel_req'];
            $senderEmail = $_SESSION['member_details']['email'];

            $delete = "DELETE FROM friend_requests WHERE sender_email = '$senderEmail' AND receiver_email = '$receiver' AND status = 'pending'";
            $delete_r = mysqli_query($this->get_connection(), $delete);

            if ($delete_r) {
                $_SESSION['success_message'] = '<script>alert("Friend request cancelled successfully.")</script>';
                echo $_SESSION['success_message'];
            } else {
                echo '<div class="alert alert-danger">Failed to cancel friend request: ' . mysqli_error($this->get_connection()) . '</div>';
            }
        }
    }

    /**
     * displaySearchResults Method
     * 
     * Displays the search results in the specified format.
     * Calls the searchUsers method to fetch results and iterates through the result set to display user information.
     *
     * @return void
     */
    public function displaySearchResults() {
        $result = $this->searchUsers();

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="user-result">';
                echo '<p>Email: ' . $row['email'] . '</p>';
                echo '<button onclick="sendFriendRequest(\'' . $row['email'] . '\')">Send Friend Request</button>';
                echo '</div>';
                exit();
            }
        } else {
            echo '<div class="alert alert-danger">Failed to fetch search results: ' . mysqli_error($this->get_connection()) . '</div>';
        }
    }
}

?>
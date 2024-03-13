<?php
session_start();
include "db.php";


/**
 * FriendList Class
 * 
 * This class extends the Database class and is designed to handle operations related to the friend list and messages.
 * It includes methods for querying the database, fetching associative arrays, retrieving the friend list,
 * getting the count of unread messages, and retrieving user details.
 */
class FriendList extends Database {
    
    /**
     * Constructor method
     * 
     * Initializes the FriendList class by checking if the user is logged in with the 'User' role.
     * Redirects to the login page if not. Calls the parent constructor to establish a database connection.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['member_details']) || $_SESSION['member_details']['role'] !== 'User') {
            header("Location: login.php");
            exit();
        }
    }

    /**
     * Query Method
     * 
     * Executes a database query using the provided SQL statement.
     *
     * @param string $sql The SQL statement to be executed.
     *
     * @return mysqli_result|bool Returns false on failure. For successful queries which produce a result set, such as SELECT, SHOW, DESCRIBE or EXPLAIN, mysqli_query() will return a mysqli_result object. For other successful queries, mysqli_query() will return true .
     */
    public function query($sql) {
        return $this->get_connection()->query($sql);
    }

    /**
     * FetchAssoc Method
     * 
     * Fetches an associative array from the result set of a database query.
     *
     * @param mixed $result The result set of a database query.
     *
     * @return array|null Returns an associative array representing the fetched row, where each key in the array represents the name of one of the result set's columns, null if there are no more rows in the result set, or false on failure.
     */
    public function fetchAssoc($result) {
        return $result->fetch_assoc();
    }

    /**
     * GetFriendList Method
     * 
     * Retrieves the friend list for the logged-in user from the database.
     *
     * @return mysqli_result|bool Returns false on failure. For successful queries which produce a result set, such as SELECT, SHOW, DESCRIBE or EXPLAIN, mysqli_query() will return a mysqli_result object. For other successful queries, mysqli_query() will return true .

     */
    public function getFriendList() {
        $user_Email = $_SESSION['member_details']['email'];
        $sql = "SELECT sender_email FROM friend_requests WHERE receiver_email = '$user_Email' AND status = 'accepted' AND sender_email != '$user_Email' ";
        $result = $this->query($sql);
        return $result;
    }

    /**
     * GetUnreadMessagesCount Method
     * 
     * Retrieves the count of unread messages between the logged-in user and a friend from the database.
     *
     * @param string $user_Email The email of the logged-in user.
     * @param string $friendEmail The email of the friend.
     *
     * @return int Returns the count of unread messages.
     */
    public function getUnreadMessagesCount($user_Email, $friendEmail) {
        $unread = "SELECT COUNT(*) AS unread_count FROM messages 
                    WHERE receiver_email = '$user_Email' AND sender_email = '$friendEmail' AND status = 'unread'";
        $unread_R = $this->query($unread);
        $unread_row = $this->fetchAssoc($unread_R);
        return $unread_row['unread_count'];
    }

    /**
     * GetUserDetails Method
     * 
     * Retrieves the details (firstname, lastname, and phone) of a user based on their email from the database.
     *
     * @param string $friendEmail The email of the user whose details need to be retrieved.
     *
     * @return array|null Returns an associative array of user details or null if there is no data.
     */
    public function getUserDetails($friendEmail) {
        $query = "SELECT firstname, lastname, phone FROM users WHERE email = '$friendEmail'";
        $result2 = $this->query($query);
        return $this->fetchAssoc($result2);
    }
}
?>

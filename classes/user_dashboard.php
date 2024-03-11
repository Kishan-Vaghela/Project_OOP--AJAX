<?php
session_start();
include "db.php";
/**
 * UserDashboard Class
 * 
 * This class extends the Database class and is designed to handle the user dashboard functionality for users with the 'User' role.
 * It includes methods to check if a user is logged in, retrieve user details, and display a registration success message.
 */

 class UserDashboard extends Database {
    /**
     * Constructor method
     * 
     * Initializes the UserDashboard class by calling the parent constructor to establish a database connection.
     * Checks if the user is logged in as a 'User'. Redirects to the login page if not.
     *
     * @return void
     */
    public function __construct() {
        if (!$this->IsUserloggedin()) {
            header("location:login.php");
            exit;
        }
        parent::__construct();
    }

    /**
     * IsUserloggedin Method
     * 
     * Checks if a user is logged in by verifying the presence of 'member_details' in the session and having the 'User' role.
     *
     * @return bool Returns true if the user is logged in as a 'User', otherwise false.
     */
    private function IsUserloggedin() {
        return isset($_SESSION['member_details']) && $_SESSION['member_details']['role'] === 'User';
    }

    /**
     * User Method
     * 
     * Retrieves user details from the database based on the user's ID and role.
     *
     * @return mixed|bool Returns the result set from the database query if successful, otherwise false.
     */
    public function User() {
        $userId = isset($_SESSION['member_details']['id']) ? $_SESSION['member_details']['id'] : 0;

        $sql = "SELECT * FROM users WHERE id = $userId AND role = 'User' ";
        $result = mysqli_query($this->get_connection(), $sql);

        if (!$result) {
            die("Query failed: " . mysqli_error($this->get_connection()));
        } else {
            return $result;
        }
    }

    /**
     * Message Method
     * 
     * Displays a registration success message if it exists in the session.
     *
     * @return void
     */
    public function Message() {
        if (isset($_SESSION['register_message'])) {
            echo "<h2>" . $_SESSION['register_message'] . "</h2><br>";
            unset($_SESSION['register_message']);
        }
    }
}
?>
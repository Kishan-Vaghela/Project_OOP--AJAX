<?php
session_start();
include 'db.php';
/**
 * AmdinDashboard Class
 * 
 * This class extends the Database class and is specifically designed for display the admin dashboard.
 * It includes functions for updating user details in the database and displaying the edit form.
 */
class AdminDashboard extends Database
{
    /** fucntion __construct is used to check the session is set or not and only admin can access the admin dashboard
     * otherwise it will redirect to login page.
     *
     * __construct()is always executed first that's why we check admin is loggin or not using session
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['member_details']) || $_SESSION['member_details']['role'] != 'admin' || ((time() - $_SESSION['member_details']['login_time']) > 600)) {
            header("Location: login.php");
            exit();
        }
    }

    /**
     * User dashboard function
     * 
     * Function fetchuser are used for the admin dashboard to get the users existing list of user present in the database
     * 
     * @return $result
     */
    public function fetchUser()
    {
        $sql = "SELECT * FROM users WHERE role = 'User'";
        $result = mysqli_query($this->get_connection(), $sql);

        if (!$result) {
            die("Query failed: " . mysqli_error($this->get_connection()));
        } else {
            return $result;
        }
        }
    }
?>
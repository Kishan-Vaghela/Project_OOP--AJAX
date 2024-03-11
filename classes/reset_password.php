<?php
session_start();
include "db.php";


/**
 * ResetPassword Class
 * 
 * This class extends the Database class and is designed to handle the reset of a user's password.
 * It includes a constructor that executes when the password reset form is submitted and updates the password in the database.
 */


class ResetPassword extends Database {
    /**
     * Constructor method
     * 
     * Initializes the ResetPassword class by calling the parent constructor to establish a database connection.
     * Checks if the 'submit' button is clicked. If so, retrieves the new password and email from the form.
     * Updates the user's password in the database and redirects to the login page upon success.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        if (isset($_POST['submit'])) {
            $newpassword = $_POST['newpassword'];
            $email = $_SESSION['reset_email']; 
        
            $sql = "UPDATE users SET password='$newpassword' WHERE email='$email'";
            $result = mysqli_query($this->get_connection(), $sql);
        
            if ($result) {
                echo "Password updated successfully";
                header("Location: login.php");
                unset($_SESSION['reset_email']);
                unset($_SESSION['verification_code']);
                exit();
            } else {
                echo "Error updating password: " . mysqli_error($this->get_connection());
            }
        }
    }
}
?>
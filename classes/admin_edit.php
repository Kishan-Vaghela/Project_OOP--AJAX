<?php
include "db.php";


/**
 * EditAdmin Class
 * 
 * This class extends the Database class and is specifically designed for handling user updates by an administrator.
 * It includes functions for updating user details in the database and displaying the edit form.
 */
class EditAdmin extends Database
{   
    /**
     * Constructor method
     * 
     * Initializes the EditAdmin class by calling the parent constructor to establish a database connection.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * updateUser Function
     * 
     * Handles the updating of user details in the database. Checks for a POST request and processes the form data.
     *
     * @return mixed Returns the query result or FALSE on failure.
     */
    public function updateUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
            $user_id = $_POST['id'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $password = $_POST['pass'];
            $address = $_POST['address'];
            $status = isset($_POST['toggle']) ? 1 : 0;

            $sql = "UPDATE users 
                    SET firstname = '$firstname', lastname = '$lastname', email = '$email', password = '$password', address='$address', status='$status'
                    WHERE id = '$user_id' ";

            $result = $this->conn->query($sql);

            if ($result === TRUE) {
                echo "<script>alert('Record Updated Successfully')</script>";
                header("Location: ../template/admin.php");
                exit;
            } else {
                echo "<script>alert('Error!')</script>" . $sql . "<br>" . $this->conn->error;
            }

            return $result;
        }
    }

    /**
     * displayForm Function
     * 
     * Displays the user details form for editing. Retrieves user data from the database based on the provided user ID.
     *
     * @return array|void Returns an array of user data or void if user ID is not set.
     */
    public function displayForm()
    {
        if (isset($_GET['id'])) {
            $user_id = $_GET['id'];
            $sql = "SELECT * FROM users WHERE id='$user_id'";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                $userData = $result->fetch_assoc();
                $this->updateUser(); // Call updateUser to handle form submission
                return $userData;
            }
        }
    }

    /**
     * goBack Function
     * 
     * Redirects the user back to the admin page if the "Back" button is clicked on the form.
     *
     * @return void
     */
    public function goBack()
    {
        if (isset($_POST['Back'])) {
            header("Location: ../template/admin.php");
            exit;
        }
    }
}
?>

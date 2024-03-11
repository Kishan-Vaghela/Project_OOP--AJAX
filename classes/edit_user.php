<?php

include "db.php";


/**
 * UserEdit Class
 * 
 * This class extends the Database class and is specifically designed for user profile editing.
 * It includes functions to display the edit form, update user details in the database, go back to the user page, 
 * and retrieve user data for a specific user ID.
 */
class UserEdit extends Database
{
    /**
     * Constructor method
     * 
     * Initializes the UserEdit class by calling the parent constructor to establish a database connection.
     * Checks for a successful database connection; otherwise, it terminates with an error message.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        if ($this->get_connection()->connect_error) {
            die("Connection failed: " . $this->get_connection()->connect_error);
        }
    }

    /**
     * displayForm Function
     * 
     * Retrieves user data based on the user ID from the URL and returns it as an array.
     */
    public function displayForm()
    {
        if (isset($_GET['id'])) {
            $user_id = $_GET['id'];
            $userData = $this->getUserData($user_id);
            return $userData;
        }
    }

    /**
     * updateRecord Function
     * 
     * Handles the updating of user details in the database. Shows previous data in the form for editing.
     * Constructs and executes an UPDATE query to update the user details in the database.
     * Redirects to the user page after successful update; otherwise, displays an error message.
     *
     * @return void
     */
    public function updateRecord()
    {
        if (isset($_POST['update'])) {
            $user_id = $_POST['id'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $password = $_POST['pass'];
            $address = $_POST['address'];

            $sql = "UPDATE users 
                    SET firstname = '$firstname', lastname = '$lastname', email = '$email', password = '$password', address='$address'
                    WHERE id = '$user_id' ";

            $result = $this->conn->query($sql);

            if ($result === TRUE) {
                echo "<script>alert('Record Updated Successfully')</script>";
                header("Location: ../template/user.php");
            } else {
                echo "<script>alert('Error!')</script>" . $sql . "<br>" . $this->get_connection()->error;
            }
        }
    }

    /**
     * goBack Function
     * 
     * Redirects the user back to the user page when they choose not to update their details.
     *
     * @return void
     */
    public function goBack()
    {
        if (isset($_POST['Back'])) {
            header("Location: ../template/user.php");
            exit;
        }
    }

    /**
     * getUserData Function
     * 
     * Retrieves user data based on the provided user ID from the database.
     *
     * @param int $user_id The user ID for which data needs to be retrieved.
     *
     * @return array|false Returns an array of user data or false if no data is found for the given user ID.
     */
    private function getUserData($user_id)
    {
        $sql = "SELECT * FROM users WHERE id='$user_id'";
        $result = $this->get_connection()->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return false;
    }
}





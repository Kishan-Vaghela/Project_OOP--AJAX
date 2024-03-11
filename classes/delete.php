<?php
include "db.php";


/**
 * User Class
 * 
 * This class extends the Database class and is dedicated to handling user-related functionalities.
 * It includes a method, deleteUser(), to delete a user from the database based on the provided User ID.
 */
class User extends Database {

    /**
     * Constructor method
     * 
     * Initializes the User class by calling the parent constructor to establish a database connection.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * deleteUser Function
     *
     * Deletes a user from the database based on the provided User ID.
     *
     * @param int $user_id The User ID that needs to be deleted.
     *
     * @return void
     */
    public function deleteUser($user_id) {
  
        // Construct SQL query to delete the user
        $sql = "DELETE FROM users WHERE id = '$user_id' ";
        $result = $this->conn->query($sql);

        // Check if the deletion was successful
        if($result == true) {
            echo "<script>alert('Record Deleted Successfully');</script>";
            header("Location: ../template/admin.php");
            exit;
        } else {
            echo "<script>alert('Error!')</script>" . $sql . "<br>" . $this->get_connection()->error;
        }
    }
}

// Create an instance of the User class
$user = new User();

// Check if User ID is set in the GET request
if(isset($_GET['id'])){
    $user_id = $_GET['id'];

    // Call the deleteUser method to delete the user
    $user->deleteUser($user_id);
}
?>
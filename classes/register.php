<?php
session_start();
include "db.php";


/**
 * Register Class
 * 
 * This class extends the Database class and is designed to handle user registration.
 * It includes a constructor that checks for the existence of a user, and a register method for processing user registration.
 */
class Register extends Database
{
    /**
     * Constructor method
     * 
     * Initializes the Register class by calling the parent constructor to establish a database connection.
     * Checks if the 'user_exists' session variable is set. If set, displays an alert message and unsets the variable.
     * Calls the register method to handle user registration.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
       
        $this->register();
    }

    /**
     * register Method
     * 
     * Handles user registration. Checks if the 'submit' button is clicked, then validates and inserts user data into the database.
     * Checks for duplicate emails and phone numbers to ensure unique registrations.
     * If registration is successful, sets the 'member_details' session variable and redirects to the user page.
     *
     * @return void
     */
    public function register()
    {
        if (isset($_POST['submit'])) {

            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $password = $_POST['pass'];
            $email = $_POST['email'];
            $phone = $_POST['phoneno'];
            $address = $_POST['address'];
            $role = "User";

            if ( empty( $email ) || empty( $phone ) ) {
                header('location: ../template/registration.php');
                return;
            }

            // Check for duplicate user entries
            $duplicate = "SELECT * FROM users";
            $duplicate_result = mysqli_query($this->get_connection(), $duplicate);

            while ($row = mysqli_fetch_array($duplicate_result, MYSQLI_ASSOC)) {
                if ($row['email'] == $email || $row['phone'] == $phone) {
                    $_SESSION['error_message'] = "User with this email or phone number already exists!";
                    header('location: ../template/registration.php');
                    exit();
                }
            }

            // Insert user data into the database
            $sql = "INSERT INTO users (firstname, lastname, password, email, phone, address, role) 
                    VALUES ('$firstname','$lastname', '$password','$email','$phone','$address','$role')";
            $result = $this->get_connection()->query($sql);

            if ($result) {
                // Set session variables for the registered user
                $_SESSION['member_details'] = array(
                    'id' => mysqli_insert_id($this->get_connection()),
                    'email' => $email,
                    'role' => $role,
                    'firstname' => $firstname,
                    'login_time' => time(),
                    'status' => 1,
                    'message' => "You are registered successfully!"
                );

                $_SESSION['register_message'] = "You are registered successfully!";

                // Redirect to the user page
                header("Location: ../template/user.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Error occurred while registering. Please try again later.";
                header('location: ../template/registration.php');
                exit();
            }
        }
    }
}

new Register();
?>
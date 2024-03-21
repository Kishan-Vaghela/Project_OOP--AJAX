<?php
session_start();
include "../classes/db.php";


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
     * Handles user registration. Validates user input and checks for duplicate emails and phone numbers before inserting user data into the database.
     * If registration is successful, sets session variables for the registered user and redirects to the user page.
     *
     * @return void
     */
    public function register()
    {
        if (isset ($_POST['submit'])) {

            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $password = $_POST['pass'];
            $email = $_POST['email'];
            $phone = $_POST['phoneno'];
            $address = $_POST['address'];
            $role = "User";
            $hash_password = hash('sha256', $password);

            $errors = array();

           
            if (empty ($firstname)) {
                $errors['firstname'] = "First name is required";
            }

            
            if (empty ($lastname)) {
                $errors['lastname'] = "Last name is required";
            }

          
            if (empty ($email)) {
                $errors['email'] = "Email is required";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email format";
            }

            if (empty ($phone)) {
                $errors['phone'] = "Phone number is required";
            } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
                $errors['phone'] = "Invalid phone number";
            }
            if (empty ($password)) {
                $errors['password'] = "Password is required";
            } elseif (strlen($password) < 6) {
                $errors['password'] = "Password must be at least 6 characters long";
            }

            $duplicate_query = "SELECT * FROM users WHERE email = '$email' OR phone = '$phone'";
            $duplicate_result = $this->get_connection()->query($duplicate_query);

            if ($duplicate_result->num_rows > 0) {
                $errors['duplicate'] = "User already exists with this email or phone number";
            }

            if (empty ($errors)) {
          
                $sql = "INSERT INTO users (firstname, lastname, password, email, phone, address, role) 
                VALUES ('$firstname', '$lastname', '$hash_password', '$email', '$phone', '$address', '$role')";
                $result = $this->get_connection()->query($sql);

                if ($result) {
                   
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
                    header("Location: ../template/user.php");
                    exit();
                } else {
                    echo "<script>alert('Error!')</script>" . $sql . "<br>" . $this->get_connection()->error;
                }
            }
        }
    }
}

?>

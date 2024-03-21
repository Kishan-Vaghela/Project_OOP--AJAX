<?php
session_start();
include "db.php";


/**
 * Login Class
 * 
 * This class extends the Database class and is designed to handle user login functionality.
 * It includes methods for handling user login, querying the database for authentication,
 * setting session variables for admin and user, and displaying alerts for invalid users.
 */
class Login extends Database
{
    /**
     * Constructor method
     * 
     * Initializes the Login class by calling the parent constructor to establish a database connection.
     * Calls the Login method to handle user login.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->Login();
    }

    /**
     * Login Method
     * 
     * Handles user login when the login form is submitted.
     * Retrieves email and password from the POST request, calls loginUser to authenticate,
     * and sets session variables based on the user's role.
     *
     * @return void
     */
    public function Login()
    {
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['pass'];
            $hash_password = hash('sha256', $password);

            $row = $this->loginUser($email, $hash_password, $this->conn);

            if ($row) {
                if ($row['role'] == 'admin') {
                    $this->setAdminSession($row);
                } elseif ($row['role'] == 'User') {
                    $this->setUserSession($row);
                }
            } else {
                $this->displayInvalidUserAlert();
            }
        }
    }

    /**
     * loginUser Method
     * 
     * Authenticates the user by querying the database with the provided email and password.
     * Returns the user details if authentication is successful; otherwise, returns null.
     *
     * @param string $email The email entered in the login form.
     * @param string $password The password entered in the login form.
     * @param mysqli $conn The database connection.
     *
     * @return array|null Returns the user details or null if authentication fails.
     */
    protected function loginUser($email, $hash_password, $conn) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$hash_password'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_array($result);
            if ($row) {
                return $row;
            }
        }
        return null;
    }

    /**
     * setAdminSession Method
     * 
     * Sets session variables for an admin user and redirects to the admin page.
     *
     * @param array $row The user details fetched from the database.
     *
     * @return void
     */
    private function setAdminSession($row) {
        $_SESSION['member_details'] = array(
            'email' => $row['email'],
            'role' => $row['role'],
            'login_time' => time(),
        );
        header("Location: admin.php");
        exit();
    }

    /**
     * setUserSession Method
     * 
     * Sets session variables for a user and redirects to the user page.
     * Displays an alert for inactive users.
     *
     * @param array $row The user details fetched from the database.
     *
     * @return void
     */
    private function setUserSession($row) {
        if ($row['status'] == '0') {
            echo "<script>alert('You are Inactive! Please Contact Admin for further details');</script>";
        } else {
            $_SESSION['member_details'] = array(
                'id' => $row['id'],
                'email' => $row['email'],
                'role' => $row['role'],
                'firstname' => $row['firstname'],
                'login_time' => time(),
                'status' => $row['status'],
                'message' => "You are login Successfully !"
            );
            header("Location: user.php");
            exit();
        }
    }

    /**
     * displayInvalidUserAlert Method
     * 
     * Displays an alert for invalid users when authentication fails.
     *
     * @return void
     */
    private function displayInvalidUserAlert() {
        echo "<script>alert('Invalid User!')</script>";
    }
}
?>
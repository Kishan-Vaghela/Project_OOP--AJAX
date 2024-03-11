<?php
session_start();
include "db.php";

/**
 * ForgotPassword Class
 * 
 * This class extends the Database class and is designed for handling the forgot password functionality.
 * It includes a method, Password(), to initiate the password reset process.
 */

class ForgotPassword extends Database{


     /**
     * Constructor method
     * 
     * Initializes the UserEdit class by calling the parent constructor to establish a database connection.
     * Checks for a successful database connection; otherwise, it terminates with an error message.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Password Function
     * 
     * Initiates the password reset process. Checks if the provided email exists in the database.
     * If the email exists, generates a verification code, stores it in the session, and sends an email to the user with the verification code.
     * Redirects to the verification page. If the email is not found, displays an error message.
     *
     * @return void
     */
    public function Password(){
        if (isset($_POST['forgot_password'])) {
            $email = $_POST['email'];
        
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($this->get_connection(), $sql);
        
            if ($result && mysqli_num_rows($result) > 0) {
                $verification_code = substr(md5(mt_rand()), 0, 6);
                $_SESSION['reset_email'] = $email;
                $_SESSION['verification_code'] = $verification_code; 
        
                $to = $email; 
                $subject = "Password Reset Verification Code";
                $message = "Your verification code is: $verification_code";
                
                // Send email with verification code
                mail($to, $subject, $message);
        
                // Redirect to verification page
                header("Location: ../template/verify.php");
                exit();
            } else {
                echo "<script>alert('Invalid Email!')</script>";
            }
        }
    }
}
?>
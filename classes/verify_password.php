<?php
session_start();
/**
 * VerifyPassword Class
 * 
 * This class is responsible for verifying the user's entered verification code during the password reset process.
 * It checks if the required session variables are set and redirects to the appropriate pages based on the verification result.
 */

 class VerifyPassword 
 {
     /**
      * verify Method
      * 
      * Verifies the entered verification code during the password reset process.
      * Checks if the required session variables ('reset_email' and 'verification_code') are set.
      * Redirects to the 'forgot_password.php' page if the session variables are not set.
      * If the verification code is entered, it compares it with the one stored in the session.
      * Redirects to the 'reset_password.php' page if the verification is successful; otherwise, it displays an error message.
      *
      * @return void
      */
     public function verify()
     {
         if (!isset($_SESSION['reset_email']) || !isset($_SESSION['verification_code'])) {
             header("Location: forgot_password.php");
             exit();
         }
 
         if (isset($_POST['submit'])) {
             $verification_code = $_POST['verification_code'];
 
             if ($_SESSION['verification_code'] === $verification_code) {
                 header("Location: reset_password.php");
                 exit();
             } else {
                 echo "Invalid verification code";
             }
         }
     }
 }
 
 ?>
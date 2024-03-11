<?php
session_start();
unset($_SESSION['member_details']);
unset($_SESSION['email']);
session_destroy();
header("Location: ../template/login.php");
exit();


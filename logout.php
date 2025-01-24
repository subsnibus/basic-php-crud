<?php
session_start();
session_unset(); // Unset all session values
session_destroy(); // Destroy the session
header("Location: login.php"); // Redirect to the login page
exit();
?>
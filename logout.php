<?php
session_start();

// Destroy the session and redirect to the login page
session_destroy();
header('Location: login.php'); // Change to your login page URL
exit;
?>
    
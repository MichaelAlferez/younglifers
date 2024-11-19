<?php
session_start();

// Destroy the session and redirect to the login page
session_destroy();
header('Location: ../../index.html'); // Change to your login page URL
exit;
?>
    
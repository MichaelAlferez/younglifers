<?php
include 'connections/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ministry_id = $_POST['ministry_id'];

    // Delete the ministry from the database
    $stmt = $pdo->prepare("DELETE FROM ministries WHERE id = ?");
    $stmt->execute([$ministry_id]);

    // Redirect back to the admin page
    header('Location: ministry_edit.php');
    exit;
}
?>

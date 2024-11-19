<?php
include 'connections/db.php';
$stmt = $pdo->query("SELECT link FROM live_stream_links WHERE id = 1");
$live_link = $stmt->fetchColumn();
header("Location: $live_link");
exit();
?>

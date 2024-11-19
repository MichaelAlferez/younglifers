<?php
include 'connections/db.php';

session_start();
// Check if the user is logged in and has a name stored in the session
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Get the current page
$current_page = basename($_SERVER['PHP_SELF']);
// Flag to check if the link was updated successfully
$link_updated = false;

// Handle link update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_link = $_POST['link'];
    $stmt = $pdo->prepare("UPDATE live_stream_links SET link = ?, date_updated = NOW() WHERE id = 1");
    if ($stmt->execute([$new_link])) {
        $link_updated = true;  // Set flag to true if update is successful
    }
}

// Fetch current link
$stmt = $pdo->query("SELECT link FROM live_stream_links WHERE id = 1");
$current_link = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

 <?php include 'components/navbar.php'?>;

    <div class="main-content">
        <h1>Latest Live Stream Link</h1>
        <form method="POST">
        <?php if (isset($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <input type="text" name="link" value="<?php echo htmlspecialchars($current_link); ?>" required />
            <br>
            <input type="submit" value="Update Link">
        </form>
        
        <?php if ($link_updated): ?>
            <p style="color: green; margin-top: 15px;">Link updated successfully!</p>
        <?php endif; ?>
    </div>

</body>
</html>

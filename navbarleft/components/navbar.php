<?php

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page or deny access if user is not logged in
    header('Location: login.php');
    exit; // Ensure no further code is executed after the redirect
}

// Retrieve the first and last name from session
$first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Guest';
$last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';

// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="navbar">
    <div>
        <!-- Display first and last name -->
        <div class="welcome">Welcome <br> <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?>!</div>
        <ul>
            <li class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>"><a href="index.php">Update Link</a></li>
            <li class="<?php echo ($current_page == 'missions.php') ? 'active' : ''; ?>"><a href="missions.php">Missions</a></li>
            <li class="<?php echo ($current_page == 'organization.php') ? 'active' : ''; ?>"><a href="organization.php">Organization</a></li>
            <li class="<?php echo ($current_page == '../projectdone/admin/admin_login.php') ? 'active' : ''; ?>"><a href="../projectdone/admin/admin_login.php">Log In Merch</a></li>
            
        </ul>
    </div>
    <a href="crud/logout.php" class="logout-btn">Log Out</a>
</div>

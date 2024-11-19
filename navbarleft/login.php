<?php
session_start();

// Include database connection
include 'connections/db.php'; // Ensure this path is correct

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the query
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    // Check if the password matches
    if ($user && $user['password'] === $password) { // Direct comparison without hashing
        // Store user info in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['first_name'] = $user['first_name']; // Store first name in session
        $_SESSION['last_name'] = $user['last_name'];   // Store last name in session

        // Redirect to admin dashboard or another page
        header('Location: index.php'); // Change to your desired location
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
    <div class="login-box">
        <div class="login-header">
            <header>Login</header>
        </div>
        <form action="" method="POST">
        <?php if (isset($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

        <div class="input-box">
            <input type="text" class="input-field" placeholder="Username" name="username" autocomplete="off" required>
        </div>
        <div class="input-box">
            <input type="password" class="input-field" placeholder="Password" name="password" autocomplete="off" required>
        </div>
        
        <div class="input-submit">
            <button class="submit-btn" id="submit"></button>
            <label for="submit">Sign In</label>
        </div>
        <a href="../../living_one/index.html">Go Back</a>
        
</form>
    </div>
</body>
</html>
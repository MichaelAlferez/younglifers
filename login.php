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

        // Redirect to admin dashboard or another page
        header('Location: admin.php'); // Change to your desired location
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Login - Living One Global Ministries</title>
    <link rel="icon" href="images/l1-removebg-preview.png"
        type="image/x-icon" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/main.css" />
</head>
<style>
        input[type="text"], input[type="password"] {
            width: 300px; /* Adjust the width here */
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .inner {
    display: flex;
    flex-direction: column;
    align-items: center; /* Center elements horizontally */
    justify-content: center; /* Center elements vertically */
    text-align: center;
            width: 100%;
            max-width: 400px; /* Adjust to your preferred width */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 10px 10px 10px  rgba(0, 0, 0, 0.1);
            background-color: #0d9088;
        }
    </style>

<div id="page-wrapper">
    <section id="login" class="wrapper style1 special">
        <div class="inner">
            <header class="major">
                <h2>Login</h2>
            </header>

            <?php if (isset($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

           ` <form method="POST" action="login.php">`
                <div>
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required />
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required />
                </div><br>
                <ul class="actions stacked">
                            <li> <button type="submit">Log In</button></li>
							<li><a href="index.html" class="button primary small">Exit</a></li>
            </ul>

            </form>
        </div>
    </section>
</div>

</body>
</html>

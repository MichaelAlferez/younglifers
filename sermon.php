<?php
include 'crud_sermon.php'; // Include your CRUD operations file

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        createSermon($_POST['title'], $_POST['description'], $_POST['image']);
    } elseif (isset($_POST['update'])) {
        updateSermon($_POST['id'], $_POST['title'], $_POST['description'], $_POST['image']);
    } elseif (isset($_POST['delete'])) {
        deleteSermon($_POST['id']);
    }
}

$sermons = getSermons(); // Fetch sermons for display

?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Admin Panel - Sermons</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
</head>
<body class="is-preload">

    <div id="page-wrapper">

        <!-- Header -->
        <header id="header">
            <h1><a href="index.html">L1</a></h1>
            <nav id="nav">
                <ul>
                    <li class="special">
                        <a href="#menu" class="menuToggle"><span>Menu</span></a>
                        <div id="menu">
                            <ul>
                                <li><a href="index.html">Home</a></li>
                                <li><a href="generic.html">Sermons and Messages</a></li>
                                <li><a href="elements.html">Ministries</a></li>
                                <li><a href="login.php">Log In</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>

        <!-- Main -->
        <article id="main">
            <header>
                <h2>Sermons Management</h2>
            </header>

            <section class="wrapper style5">
                <div class="inner">
                    <!-- Create Sermon Form -->
                    <h3>Create Sermon</h3>
                    <form method="post">
                        <input type="text" name="title" placeholder="Sermon Title" required>
                        <textarea name="description" placeholder="Sermon Description" required></textarea>
                        <input type="text" name="image" placeholder="Image URL" required>
                        <button type="submit" name="create">Create</button>
                    </form>

                    <hr />

                    <h3>Manage Sermons</h3>
                    <table border="1">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($sermons as $sermon): ?>
                        <tr>
                            <td><?php echo $sermon['id']; ?></td>
                            <td><?php echo $sermon['title']; ?></td>
                            <td><?php echo $sermon['description']; ?></td>
                            <td><img src="<?php echo $sermon['image']; ?>" alt="" width="100"></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $sermon['id']; ?>">
                                    <input type="text" name="title" value="<?php echo $sermon['title']; ?>" required>
                                    <textarea name="description" required><?php echo $sermon['description']; ?></textarea>
                                    <input type="text" name="image" value="<?php echo $sermon['image']; ?>" required>
                                    <button type="submit" name="update">Update</button>
                                </form>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $sermon['id']; ?>">
                                    <button type="submit" name="delete" onclick="return confirm('Are you sure?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </section>
        </article>

        <!-- Footer -->
        <footer id="footer">
            <ul class="icons">
                <li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
                <li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
                <li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
                <li><a href="#" class="icon brands fa-dribbble"><span class="label">Dribbble</span></a></li>
                <li><a href="#" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
            </ul>
            <ul class="copyright">
                <li>&copy; Untitled</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
            </ul>
        </footer>

    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

</body>
</html>

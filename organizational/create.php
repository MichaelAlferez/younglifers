<?php
// admin.php
include '../connections/db.php';

// Handle Create
if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
}
    // Handle file upload for the ministry image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploads/'; // Folder to save the image
        $image_path = $image_folder . basename($image_name);

        // Move the uploaded image to the target directory
        if (move_uploaded_file($image_tmp_name, $image_path)) {
            // Insert the new ministry into the database
            $stmt = $pdo->prepare("INSERT INTO members (name, role, image_path) VALUES (?, ?, ?)");
            $stmt->execute([$name, $role, $image_path]);
    } else {
        echo "File upload failed.";
    }
}

// Handle Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    // Handle file upload
    $image_path = 'images/' . basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
        // Update member in database
        $stmt = $pdo->prepare("UPDATE members SET name = ?, role = ?, image_path = ? WHERE id = ?");
        $stmt->execute([$name, $role, $image_path, $id]);
    } else {
        echo "File upload failed.";
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM members WHERE id = ?");
    $stmt->execute([$id]);
}

// Retrieve members
$stmt = $pdo->query("SELECT * FROM members");
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pdo = null; // Close the database connection
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Living One Global Ministries</title>
    <link rel="icon" href="images/l1-removebg-preview.png" type="image/x-icon" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .edit,
        .delete {
            color: blue;
            text-decoration: none;
        }

        .delete {
            color: red;
        }
    </style>
</head>

<body class="landing is-preload">

    <!-- Page Wrapper -->
    <div id="page-wrapper">

        <!-- Header -->
        <header id="header" class="alt">
            <h1><a href="index.html">L1</a></h1>
            <nav id="nav">
                <ul>
                    <li class="special">
                        <a href="#menu" class="menuToggle"><span>Menu</span></a>
                        <div id="menu">
                            <ul>
                                <li><a href="index.html">Home</a></li>
                                <li><a href="organizational.php">Organizational Chart</a></li>
                                <li><a href="ministries.php">Missions</a></li>
                                <li><a href="generic.php">Testimonies</a></li>
                                <li><a href="#">Merch</a></li>
                                <li><a href="login.php">Log In</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>

        <!-- Banner -->
        <section id="banner">
            <div class="inner">
                <h2>Organizational Chart</h2>
            </div>
        </section>

        <!-- Organizational Chart -->
        <section id="org-chart" class="wrapper alt style2">
        <h1>Admin Panel</h1>

<!-- Create Form -->
<h2>Add New Member</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="role" placeholder="Role" required>
    <input type="file" name="image" required>
    <button type="submit" name="create">Add Member</button>
</form>

<!-- Members List -->
<h2>Members List</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Role</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($members as $member) : ?>
            <tr>
                <td><?php echo htmlspecialchars($member['id']); ?></td>
                <td><?php echo htmlspecialchars($member['name']); ?></td>
                <td><?php echo htmlspecialchars($member['role']); ?></td>
                <td><img src="<?php echo htmlspecialchars($member['image_path']); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>" width="50"></td>
                <td>
                    <a class="edit" href="edit.php?id=<?php echo $member['id']; ?>">Edit</a> |
                    <a class="delete" href="?delete=<?php echo $member['id']; ?>" onclick="return confirm('Are you sure you want to delete this member?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
        </section>

        <!-- Footer -->
        <footer id="footer">
            <ul class="icons">
                <li><a href="#" class="icon brands fa-facebook-f"><span class="label">Email</span></a></li>
                <li><a href="#" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
            </ul>
            <ul class="copyright">
                <li>
                    <h4>Living One Global Ministries</h4>
                </li>
                <li>
                    <p>Bayubay Sur, San Vicente Ilocos Sur</p>
                </li>
            </ul>
        </footer>

    </div>

    <!-- Scripts -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery.scrollex.min.js"></script>
    <script src="../assets/js/jquery.scrolly.min.js"></script>
    <script src="../assets/js/browser.min.js"></script>
    <script src="../assets/js/breakpoints.min.js"></script>
    <script src="../assets/js/util.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>


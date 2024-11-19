<?php
include 'connections/db.php'; // Include your database connection file
session_start();

// Initialize variables
$modal_message = "";
$modal_status = false;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        // Create
        $title = $_POST['title'];
        $description = $_POST['description'];
        $bible_verse = $_POST['bible_verse'];

        // Handle image uploads
        $image_folder = 'uploads/';
        $main_image = '';
        $thumbnail_image = '';
        $secondary_image = '';

        // Upload main image
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
            $main_image_name = $_FILES['main_image']['name'];
            $main_image_tmp_name = $_FILES['main_image']['tmp_name'];
            $main_image_path = $image_folder . basename($main_image_name);

            if (move_uploaded_file($main_image_tmp_name, $main_image_path)) {
                $main_image = $main_image_path;
            } else {
                $modal_message = "Error uploading the main image.";
                $modal_status = true;
            }
        }

        // Upload thumbnail image
        if (isset($_FILES['thumbnail_image']) && $_FILES['thumbnail_image']['error'] == 0) {
            $thumbnail_image_name = $_FILES['thumbnail_image']['name'];
            $thumbnail_image_tmp_name = $_FILES['thumbnail_image']['tmp_name'];
            $thumbnail_image_path = $image_folder . basename($thumbnail_image_name);

            if (move_uploaded_file($thumbnail_image_tmp_name, $thumbnail_image_path)) {
                $thumbnail_image = $thumbnail_image_path;
            } else {
                $modal_message = "Error uploading the thumbnail image.";
                $modal_status = true;
            }
        }

        // Upload secondary image
        if (isset($_FILES['secondary_image']) && $_FILES['secondary_image']['error'] == 0) {
            $secondary_image_name = $_FILES['secondary_image']['name'];
            $secondary_image_tmp_name = $_FILES['secondary_image']['tmp_name'];
            $secondary_image_path = $image_folder . basename($secondary_image_name);

            if (move_uploaded_file($secondary_image_tmp_name, $secondary_image_path)) {
                $secondary_image = $secondary_image_path;
            } else {
                $modal_message = "Error uploading the secondary image.";
                $modal_status = true;
            }
        }

        // Insert into database if all images are uploaded successfully
        if ($main_image && $thumbnail_image && $secondary_image) {
            $stmt = $pdo->prepare("INSERT INTO sermons (title, description, bible_verse, main_image, thumbnail_image, secondary_image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $bible_verse, $main_image, $thumbnail_image, $secondary_image]);
            $modal_message = "Sermon added successfully!";
            $modal_status = true;
        }
    } elseif (isset($_POST['delete'])) {
        // Delete
        $id = $_POST['sermon_id'];
        $stmt = $pdo->prepare("DELETE FROM sermons WHERE id = ?");
        $stmt->execute([$id]);
        $modal_message = "Sermon deleted successfully!";
        $modal_status = true;
    }
}

// Fetch sermons for display
$stmt = $pdo->query("SELECT * FROM sermons");
$sermons = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Living One Young Lifers</title>
    <link rel="icon" href="images/l1-removebg-preview.png"
        type="image/x-icon" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>

    <style>
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    .video-link {
        max-width: 150px; /* Set a max width for the link column */
        overflow: hidden; /* Hide overflow */
        white-space: nowrap; /* Prevent line breaks */
        text-overflow: ellipsis; /* Add ellipsis for overflowed text */
        display: inline-block; /* Allow the text overflow properties to work */
        color: black;
    }

    .video-link a {
        color: #007BFF; /* Change to a color that contrasts well */
        text-decoration: none; /* Remove underline for better readability */
    }

    .video-link a:hover {
        text-decoration: underline; /* Add underline on hover for emphasis */
        color: #0056b3; /* Darker shade on hover */
    }

    .video-link:hover {
        overflow: visible; /* Show full link on hover */
        white-space: normal; /* Allow text to wrap */
        background-color: #f9f9f9; /* Optional: Background for better visibility */
        position: relative; /* Allow positioning */ 
        border: 1px solid #ddd; /* Optional: Border for clarity */
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        padding-top: 100px;
    }

    .modal-content {
        background-color: white;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        max-width: 400px;
        text-align: center;
        border-radius: 8px;
    }

    .modal-content p {
        color: #333;
        font-size: 18px;
        padding-top: 40px;
    }

    .modal-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        margin: 10px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
    }

    .modal-button:hover {
        background-color: #45a049;
    }

    .modal-button.cancel {
        background-color: #f44336; /* Red color for cancel button */
    }

    .modal-button.cancel:hover {
        background-color: #e53935; /* Darker red on hover */
    }

    </style>
</head>
<body class="landing is-preload">

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
                            <li><a href="admin.php">Update Link</a></li>
                            <li><a href="ministry_edit.php">Edit Ministry</a></li>
                            <li><a href="admin_youth.php">Edit Youth</a></li>
                            <li><a href="organizational/edit.php">Edit Organizational</a></li>
                            <li><a href="logout.php">Log Out</a></li> <!-- Link to logout.php -->
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Admin Form to Add New Sermon -->
    <section id="banner">
        <div class="inner">
            <h2>Admin - Add Testimony</h2>
        </div>
    </section>

    <section>
    <form method="POST" enctype="multipart/form-data">
                <label for="title">Name:</label>
                <input type="text" name="title" required />
                <label for="description">Testimony of life:</label>
                <textarea name="description" required></textarea>
                <label for="bible_verse">Bible Verse:</label>
                <input type="text" name="bible_verse" />
                <label for="main_image">Upload Main Image:</label>
                <input type="file" name="main_image" accept="image/*" required />
                <label for="thumbnail_image">Upload Thumbnail Image:</label>
                <input type="file" name="thumbnail_image" accept="image/*" required />
                <label for="secondary_image">Upload Secondary Image:</label>
                <input type="file" name="secondary_image" accept="image/*" required />
                <button type="submit" name="add">Add Testimony</button>
            </form>
    </section>
    <!-- Display List of Sermons for Admin Management -->
<section id="two" class="wrapper alt style2">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Testimony of life</th>
                <th>Video Link</th>
                <th>Bible Verse</th>
                <th>Main Image</th>
                <th>Thumbnail</th>
                <th>Secondary Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($sermons)): ?>
                <tr>
                    <td colspan="8" style="text-align: center; color: #e85154;">No sermons yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($sermons as $sermon): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sermon['title']); ?></td>
                        <td><?php echo htmlspecialchars($sermon['description']); ?></td>
                        <td class="video-link"><a href="<?php echo htmlspecialchars($sermon['video_link']); ?>"><?php echo htmlspecialchars($sermon['video_link']); ?></a></td>
                        <td><?php echo htmlspecialchars($sermon['bible_verse']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($sermon['main_image']); ?>" alt="" width="50" /></td>
                        <td><img src="<?php echo htmlspecialchars($sermon['thumbnail_image']); ?>" alt="" width="50" /></td>
                        <td><img src="<?php echo htmlspecialchars($sermon['secondary_image']); ?>" alt="" width="50" /></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="sermon_id" value="<?php echo $sermon['id']; ?>" />
                                <button type="submit" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</section>

</div>

<!-- Modal Structure -->
<div id="modal" class="modal" style="<?php echo $modal_status ? 'display: flex;' : 'display: none;'; ?>">
    <div class="modal-content">
        <p><?php echo $modal_message; ?></p>
        <button class="modal-button" onclick="this.parentElement.parentElement.style.display='none';">OK</button>
    </div>
</div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>

<script>
    // Handle modal display logic
    var modal = document.getElementById('modal');
    if ("<?php echo $modal_status ? 'true' : 'false'; ?>" === 'true') {
        modal.style.display = 'flex';
    }

    // Close modal on click of any close button or OK button
    document.querySelector('.modal-button').onclick = function() {
        modal.style.display = 'none';
    };

    // Close modal if user clicks outside of the modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>

</body>
</html>

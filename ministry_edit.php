<?php
include 'connections/db.php';

// Start session to manage user authentication
session_start();

// Initialize variables for modal message
$modal_message = "";
$modal_status = false;

// Handle form submission to create or update a ministry
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle file upload for the ministry image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploads/'; // Folder to save the image
        $image_path = $image_folder . basename($image_name);

        // Move the uploaded image to the target directory
        if (move_uploaded_file($image_tmp_name, $image_path)) {
            // Insert the new ministry into the database
            $stmt = $pdo->prepare("INSERT INTO ministries (title, description, image) VALUES (?, ?, ?)");
            $stmt->execute([$title, $description, $image_path]);
            
            // Trigger success modal
            $modal_message = "Ministry added successfully!";
            $modal_status = true;
        } else {
            $modal_message = "Error uploading the image.";
            $modal_status = true;
        }
    } else {
        $modal_message = "Image upload error or no image selected.";
        $modal_status = true;
    }
}

// Fetch ministries for display in the frontend
$stmt = $pdo->query("SELECT * FROM ministries");
$ministries = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Living One Global Ministries</title>
    <link rel="icon" href="images/l1-removebg-preview.png"
        type="image/x-icon" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>

    <style>
        /* Modal Styling */
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
    padding: 0px 20px; /* Increased paddin g for better button size */
    margin: 10px; /* Added margin for space between buttons */
    border: none;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px; /* Consistent font size */
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

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    cursor: pointer;
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
                            <li><a href="admin.php">Update Link</a></li>
                            <li><a href="admin_sermon.php">Edit Sermon</a></li>
                            <li><a href="admin_youth.php">Edit Youth</a></li>
                            <li><a href="organizational/edit.php">Edit Organizational</a></li>
                            <li><a href="logout.php">Log Out</a></li> <!-- Link to logout.php -->
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Admin Form to Add New Ministry -->
    <section id="banner">
        <div class="inner">
            <h2>Admin - Add Ministry</h2>
        </div>
    </section>

    <section>
    <form method="POST" enctype="multipart/form-data">
                <label for="title">Ministry Title:</label>
                <input type="text" name="title" required />

                <label for="description">Ministry Description:</label>
                <textarea name="description" required></textarea>

                <label for="image">Upload Ministry Image:</label>
                <input type="file" name="image" accept="image/*" required />

                <button type="submit">Add Ministry</button>
            </form>
</section>

    <!-- Display List of Ministries for Admin Management -->
    <section id="two" class="wrapper alt style2">
        <?php foreach ($ministries as $ministry): ?>
            <section class="spotlight">
                <div class="image"><img src="<?php echo htmlspecialchars($ministry['image']); ?>" alt="" /></div>
                <div class="content">
                    <h2><?php echo htmlspecialchars($ministry['title']); ?><br /></h2>
                    <p><?php echo htmlspecialchars($ministry['description']); ?></p>

                    <!-- Option to Delete Ministry -->
                    <button class="delete-button" data-id="<?php echo $ministry['id']; ?>">Delete</button>
                </div>
            </section>
        <?php endforeach; ?>
    </section>

</div>

<!-- Modal Structure for Deleting -->
<div id="delete-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Are you sure you want to delete this ministry?</p>
        <form id="delete-form" method="POST" action="delete_ministry.php">
            <input type="hidden" name="ministry_id" id="ministry-id">
            <button type="submit" class="modal-button">Confirm Delete</button>
            <button type="button" class="modal-button cancel">Cancel</button>
        </form>
    </div>
</div>

<!-- Modal Structure -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p><?php echo $modal_message; ?></p>
        <button class="modal-button">OK</button>
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
// Get modal and close elements for add ministry
var modal = document.getElementById('modal');
var closeBtns = document.querySelectorAll('.close'); // Select all close buttons
var okBtn = modal.querySelector('.modal-button'); // The OK button within the modal

// PHP variable to trigger modal
var modalStatus = "<?php echo $modal_status ? 'true' : 'false'; ?>";

// Show modal if triggered by PHP
if (modalStatus === 'true') {
    modal.style.display = 'block';
}

// Close modal on click of any close button or OK button
closeBtns.forEach(btn => {
    btn.onclick = function() {
        modal.style.display = 'none';
        deleteModal.style.display = 'none'; // Ensure delete modal also closes
    };
});

okBtn.onclick = function() {
    modal.style.display = 'none';
}

// Close modal if user clicks outside of the modal
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
    if (event.target == deleteModal) {
        deleteModal.style.display = 'none';
    }
}

// Delete confirmation modal
var deleteModal = document.getElementById('delete-modal');
var deleteButtons = document.querySelectorAll('.delete-button');
var deleteForm = document.getElementById('delete-form');
var ministryIdInput = document.getElementById('ministry-id');

// Attach click event to all delete buttons
deleteButtons.forEach(button => {
    button.onclick = function() {
        var ministryId = button.getAttribute('data-id');
        ministryIdInput.value = ministryId; // Set the ministry ID in the form
        deleteModal.style.display = 'block'; // Show the modal
    }
});

// Close delete modal when clicking on the close button or outside the modal
closeBtns.forEach(btn => {
    btn.onclick = function() {
        deleteModal.style.display = 'none';
    };
});

// Attach click event to cancel button
var cancelBtn = document.querySelector('.modal-button.cancel');
cancelBtn.onclick = function() {
    deleteModal.style.display = 'none'; // Close delete modal
}


</script>

</body>
</html>
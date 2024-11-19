<?php
include 'connections/db.php';
session_start();

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

    <!-- Modal CSS -->
    <style>
        /* The Modal (background) */
       /* Modal Styling */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
    text-align: center;
}

/* Modal Text */
.modal-content p {
    margin-top: 30px;
    color: #333;
    font-size: 18px;
}

/* Close Button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* OK Button */
.modal-button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white; /* Ensure text color is white */
    padding: 0px 20px;
    text-align: center;
    font-size: 16px;
    margin: 20px 0;
    cursor: pointer;
    border-radius: 5px;
}

.modal-button:hover {
    background-color: #45a049; /* Slightly darker green on hover */
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
                            <li><a href="ministry_edit.php">Edit Ministry</a></li>
                            <li><a href="admin_sermon.php">Edit Sermon</a></li>
                            <li><a href="admin_youth.php">Edit Youth</a></li>
                            <li><a href="organizational/edit.php">Edit Organizational</a></li>
                            <li><a href="projectdone/admin/admin_login.php">Admin Merch</a></li>
                            <li><a href="logout.php">Log Out</a></li> <!-- Link to logout.php -->
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Banner -->
    <section id="banner">
        <div class="inner">
            <h2>ADMIN</h2>
            <h1>Update Live Stream Link</h1>
            <form method="POST">
                <input type="text" name="link" value="<?php echo htmlspecialchars($current_link); ?>" required />
                <br>
                <button type="submit">Update Link</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer id="footer">
        <ul class="icons">
            <li><a href="https://www.facebook.com/LivingOneHouseofPraise" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
            <li><a href="#" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
        </ul>
        <ul class="copyright">
            <li><h4>Living One Global Ministries</h4></li>
            <li><p>Bayubay Sur, San Vicente Ilocos Sur</p></li>
        </ul>
    </footer>

</div>

<!-- Success Modal -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Live stream link updated successfully!</p>
        <button class="modal-button" onclick="closeModal()">OK</button>
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

<!-- Modal Script -->
<script>
    // Get the modal
    var modal = document.getElementById("successModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // Function to close the modal
    function closeModal() {
        modal.style.display = "none";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Show modal if the link was updated
    <?php if ($link_updated) : ?>
        modal.style.display = "block";
    <?php endif; ?>
</script>

</body>
</html>

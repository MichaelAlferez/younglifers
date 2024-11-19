

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
                            <li><a href="ministry_edit.php">Edit Ministry</a></li>
                            <li><a href="admin_sermon.php">Edit Sermon</a></li>
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
            <h2>Admin Youth</h2>
        </div>
    </section>

    <!-- Video Upload Form -->
    <div class="video-upload-form">
            <h2>Upload Video</h2>
            <form action="process_upload.php" method="POST" enctype="multipart/form-data">

                <label for="video">Upload Video:</label>
                <input type="file" name="video" accept="video/*" required />

                <button type="submit">Upload Video</button>
            </form>
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
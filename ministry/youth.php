

<!DOCTYPE HTML>
<html>

<head>
<title>Living One Global Ministries</title>
		<link rel="icon" href="../images/l1-removebg-preview.png"
        type="image/x-icon" />
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
		<link rel="stylesheet" href="../assets/css/main.css" />
        <link href="../assets/css/video_youth.css" rel="stylesheet">
		<noscript><link rel="stylesheet" href="../assets/css/noscript.css" /></noscript>
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
                                <li><a href="generic.html">Sermons and Messages</a></li>
                                <li><a href="ministries.php">Ministries</a></li>
                                <li><a href="../login.php">Log In</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>

        <!-- Banner -->
        <section id="banner">
            <div class="inner">
                <h2>Youth Ministry</h2>
                <p>"Come and join us in youth ministry, where together we can grow, learn, and make a difference!"</p>
            </div>
        </section>

          <!-- Video Display Section -->
        <div class="video-container">
            <h2>Uploaded Videos</h2>
            <?php
            session_start(); // Start the session
            include '../connections/db.php'; // Include your database connection file

            // Handle video upload
            if (isset($_POST['upload'])) {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $video = $_FILES['video'];

                $videoName = time() . '_' . basename($video['name']);
                $targetDirectory = 'uploads/';
                $targetFilePath = $targetDirectory . $videoName;

                // Move uploaded file to target directory
                if (move_uploaded_file($video['tmp_name'], $targetFilePath)) {
                    // Prepare and execute insert query
                    $sql = "INSERT INTO videos (title, description, file_name) VALUES (:title, :description, :file_name)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([':title' => $title, ':description' => $description, ':file_name' => $videoName]);
                    echo "<p>Video uploaded successfully!</p>";
                } else {
                    echo "<p>Failed to upload video.</p>";
                }
            }

            // Fetch video data
            $sql = "SELECT file_name FROM videos";
            $stmt = $pdo->query($sql);

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<video width="600" controls>';
                    echo '<source src="uploads/' . htmlspecialchars($row["file_name"]) . '" type="video/mp4">';
                    echo 'Your browser does not support the video tag.';
                    echo '</video><br>';
                }
            } else {
                echo "No videos found.";
            }
            ?>
        </div>

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
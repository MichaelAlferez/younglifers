<?php
include 'connections/db.php';

// Fetch ministries for display on the public site
$stmt = $pdo->query("SELECT * FROM ministries");
$ministries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Living One Global Ministries</title>
    <link rel="icon" href="images/l1-removebg-preview.png" type="image/x-icon" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/mission.css" />
</head>
<style>
    /* Change the color of the select element */
    #demo-category {
        color: #026670;
        /* Change this to your desired text color */
        padding: 10px;
        /* Optional: Adjust padding for better spacing */
        border: 1px solid #ccc;
        /* Optional: Adjust border style */
        border-radius: 4px;
        /* Optional: Adjust border radius */
        background-color: #f0f9f4;
        /* Optional: Adjust background color */
    }


</style>

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
											<li><a href="organizational/organizational.php">Organizational Chart</a></li>
											<li><a href="ministries.php">Missions</a></li>
											<li><a href="generic.php">Testimonies</a></li>
											<li><a href="projectdone">Merch</a></li>
											<li><a href="navbarleft/login.php">Log In</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>

        <!-- Banner -->
        <section id="banner">
            <div class="inner">
                <h2>M I S S I O N S</h2>
                <p>Our youth ministry exists to guide and empower young people in their spiritual journey by fostering a deep relationship with God, building strong Christian values, and creating a supportive community. Through worship, service, and fellowship, we aim to inspire and equip the youth to live out their faith, serve others, and grow as disciples of Christ.</p>
        </section>
       
        <!-- Display Ministries -->
        <section id="two" class="wrapper alt style2">
            <?php foreach ($ministries as $ministry): ?>
                <section class="spotlight">
                    <div class="image"><img src="<?php echo htmlspecialchars($ministry['image']); ?>" alt="" /></div>
                    <div class="content">
                        <h2><?php echo htmlspecialchars($ministry['title']); ?><br /></h2>
                        <p><?php echo htmlspecialchars($ministry['description']); ?></p>
                    </div>
                </section>
            <?php endforeach; ?>
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
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>
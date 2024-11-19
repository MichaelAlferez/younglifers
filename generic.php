<!DOCTYPE HTML>
<html>

<head>
    <title>Living One Global Ministries</title>
    <link rel="icon" href="images/l1-removebg-preview.png"
        type="image/x-icon" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="assets/css/noscript.css" />
    </noscript>
</head>

<body class="is-preload">

    <!-- Page Wrapper -->
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
											<li><a href="organizational.php">Organizational Chart</a></li>
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

        <!-- Main -->
        <article id="main">
            <header>
                <h2>Testimony</h2>
                <p>Young people's testimonies often highlight their journeys 
                    of faith, resilience, and transformation, showcasing
                     how personal experiences and community support have 
                     shaped their lives.</p>
            </header>
            <section class="wrapper style5">
                <div class="inner">

                    <?php
                    // Database connection
                    include 'connections/db.php';

                    // Fetch sermons
                    $stmt = $pdo->query("SELECT * FROM sermons");
                    $sermons = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Check if there are any sermons
                    if (empty($sermons)): ?>
                        <div class="box alt">
                            <h2>No testimonies yet.</h2>
                            <p>Stay tuned for upcoming testimonies of young people!</p>
                        </div>
                    <?php else: ?>
                        <!-- Display sermons -->
                        <?php foreach ($sermons as $sermon): ?>
                            <div class="box alt">
                                <h2><?php echo htmlspecialchars($sermon['title']); ?></a></h2>
                                <div class="row gtr-50 gtr-uniform">
                                    <div class="col-4 col-12-small">
                                        <span class="image fit">
                                            <img src="<?php echo htmlspecialchars($sermon['main_image']); ?>" alt="Main Image" />
                                        </span>
                                    </div>
                                    <div class="col-4 col-6-small">
                                        <span class="image fit">
                                            <img src="<?php echo htmlspecialchars($sermon['thumbnail_image']); ?>" alt="Thumbnail Image" />
                                        </span>
                                    </div>
                                    <div class="col-4 col-6-small">
                                        <span class="image fit">
                                            <img src="<?php echo htmlspecialchars($sermon['secondary_image']); ?>" alt="Secondary Image" />
                                        </span>
                                    </div>
                                    <div class="col-6 col-12-small">
                                        <span> <?php echo htmlspecialchars($sermon['description']); ?></span>
                                    </div>
                                    <div class="col-6 col-12-small">
                                        <span> <?php echo htmlspecialchars($sermon['bible_verse']); ?></span>
                                    </div>
                                </div>
                                <hr />
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

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
                <li>&copy; Living One Global Ministries</li>
                <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
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

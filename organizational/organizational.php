<!DOCTYPE HTML>
<html>

<head>
    <title>Living One Global Ministries</title>
    <link rel="icon" href="images/l1-removebg-preview.png" type="image/x-icon" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="../assets/css/core.css" />
    <link href="../assets/css/org.css" rel="stylesheet" />
    <link href="../assets/css/org_edit.css" rel="stylesheet" />
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
                                <li><a href="../index.html">Home</a></li>
                                <li><a href="organizational.html">Organizational Chart</a></li>
                                <li><a href="../ministries.html">Missions</a></li>
                                <li><a href="../generic.html">Testimonies</a></li>
                                <li><a href="../projectdone/">Merch</a></li>
                                <li><a href="../navbarleft/login.html">Log In</a></li>
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
            <div class="container">
                <div class="chart">
                    <!-- Static Organizational Chart -->
                    <div class="level">
                        <div class="node">
                            <div class="image-container">
                                <img src="uploads/456715253_2449388515263268_7577053731927412339_n.jpg" class="profile-image" alt="John Doe">
                                <div class="overlay">
                                    <div class="overlay-text">Faith is the visionary behind our ministry, guiding us with faith and determination.</div>
                                </div>
                            </div>
                            <div class="name">Faith Rubio</div>
                            <div class="role">Younglifers Director</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal for introduction -->
        <div id="introModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeIntroModal">&times;</span>
                <h2>Introduction</h2>
                <p id="introText"></p>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery.scrollex.min.js"></script>
    <script src="../assets/js/jquery.scrolly.min.js"></script>
    <script src="../assets/js/browser.min.js"></script>
    <script src="../assets/js/breakpoints.min.js"></script>
    <script src="../assets/js/util.js"></script>
    <script src="../assets/js/main.js"></script>

    <script>
        // JavaScript to handle introduction modal
        const profileLinks = document.querySelectorAll('.profile-link');
        const introModal = document.getElementById('introModal');
        const introText = document.getElementById('introText');
        const closeIntroModal = document.getElementById('closeIntroModal');

        profileLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault(); // Prevent default link behavior
                const introduction = link.getAttribute('data-intro');
                introText.textContent = introduction;

                // Get the bounding rectangle of the clicked link
                const rect = link.getBoundingClientRect();

                // Set the position of the modal
                introModal.style.left = (rect.right + 20) + "px"; // Place it to the right of the link
                introModal.style.top = (rect.top + window.scrollY - 130) + "px"; // Adjust position higher by subtracting a fixed amount

                introModal.style.display = "block"; // Show the modal
            });
        });

        // Close modal on clicking the close button
        closeIntroModal.onclick = function () {
            introModal.style.display = "none";
        }

        // Close modal on clicking outside
        window.onclick = function (event) {
            if (event.target == introModal) {
                introModal.style.display = "none";
            }
        }
    </script>
</body>

</html>

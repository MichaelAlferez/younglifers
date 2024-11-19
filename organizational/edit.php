<?php
include '../connections/db.php'; // Ensure this sets up $pdo

// Fetch existing entries
try {
    $stmt = $pdo->query("SELECT * FROM org_chart ORDER BY level, id");
    $org_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo 'Query failed: ' . $e->getMessage();
    $org_data = []; // Ensure $org_data is always an array
}

// Check if $org_data is empty
if (empty($org_data)) {
    echo '<p>No organizational data found.</p>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Living One Global Ministries</title>
    <link rel="icon" href="images/l1-removebg-preview.png" type="image/x-icon" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link href="../assets/css/other_org.css" rel="stylesheet" />
    <link href="../assets/css/modal_update.css" rel="stylesheet" />
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
                            <li><a href="../admin.php">Update Link</a></li>
                            <li><a href="../ministry_edit.php">Edit Ministry</a></li>
                            <li><a href="../admin_sermon.php">Edit Sermon</a></li>
                            <li><a href="../admin_youth.php">Edit Youth</a></li>
                            <li><a href="../logout.php">Log Out</a></li> <!-- Link to logout.php -->
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

        <section>
            <div class="container">
                <h2>Add Member</h2>
                <form action="org_chart.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="name" placeholder="Name" required>
                    <input type="text" name="role" placeholder="Role" required>
                    <input type="file" name="image" accept="image/*" required>
                    <input type="number" name="level" placeholder="Level" required>
                    <input type="text" name="introduction" placeholder="Brief Introduction" required>
                    <button type="submit" name="add">Add</button>
                </form>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="chart">
                    <?php
                    $levels = []; // Array to hold nodes by level

                    foreach ($org_data as $entry) {
                        $levels[$entry['level']][] = $entry; // Group entries by level
                    }

                    foreach ($levels as $level => $entries) {
                        echo '<div class="level">';
                        foreach ($entries as $entry) {
                            echo '<div class="node">';
                            echo '<img src="' . htmlspecialchars($entry['image_url']) . '" class="profile-image" alt="' . htmlspecialchars($entry['name']) . '">';
                            echo '<div class="name"><a href="#" class="profile-link" data-intro="' . htmlspecialchars($entry['introduction']) . '">' . htmlspecialchars($entry['name']) . '</a></div>';
                            echo '<div class="role">' . htmlspecialchars($entry['role']) . '</div>';
                            echo '<button class="update-btn" data-id="' . $entry['id'] . '" data-name="' . htmlspecialchars($entry['name']) . '" data-role="' . htmlspecialchars($entry['role']) . '" data-level="' . $entry['level'] . '" data-image="' . htmlspecialchars($entry['image_url']) . '" data-intro="' . htmlspecialchars($entry['introduction']) . '">Update</button>';
                            echo '<form action="org_chart.php" method="POST" style="display:inline;">';
                            echo '<input type="hidden" name="id" value="' . $entry['id'] . '">';
                            echo '<button type="submit" name="delete">Delete</button>';
                            echo '</form>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo '<div class="connector"></div>';
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- Modal for updating member -->
        <div id="updateModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeUpdateModal">&times;</span>
                <h2>Update Member</h2>
                <form id="updateForm" action="org_chart.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="updateId">
                    <input type="text" name="name" id="updateName" placeholder="Name" required>
                    <input type="text" name="role" id="updateRole" placeholder="Role" required>
                    <input type="file" name="image" id="updateImage" accept="image/*">
                    <input type="number" name="level" id="updateLevel" placeholder="Level" required>
                    <input type="text" name="introduction" id="updateIntroduction" placeholder="Brief Introduction" required>
                    <button type="submit" name="update">Update</button>
                </form>
            </div>
        </div>

        <!-- Modal for introduction -->
        <div id="introModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeIntroModal">&times;</span>
                <h2>Brief Introduction</h2>
                <p id="introText"></p>
            </div>
        </div>

    </div>
               
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
        const updateModal = document.getElementById("updateModal");
        const closeUpdateModal = document.getElementById("closeUpdateModal");
        const updateBtns = document.querySelectorAll(".update-btn");

        updateBtns.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const role = button.getAttribute('data-role');
                const level = button.getAttribute('data-level');
                const image = button.getAttribute('data-image');
                const introduction = button.getAttribute('data-intro'); // Get the introduction

                // Set the values in the update modal
                document.getElementById('updateId').value = id;
                document.getElementById('updateName').value = name;
                document.getElementById('updateRole').value = role;
                document.getElementById('updateLevel').value = level;
                document.getElementById('updateIntroduction').value = introduction; // Set the introduction value

                updateModal.style.display = "block";
            });
        });

        closeUpdateModal.onclick = function () {
            updateModal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target === updateModal) {
                updateModal.style.display = "none";
            }
        }

        // JavaScript for introduction modal
        const profileLinks = document.querySelectorAll('.profile-link');
        const introModal = document.getElementById('introModal');
        const introText = document.getElementById('introText');
        const closeIntroModal = document.getElementById('closeIntroModal');

        profileLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault(); // Prevent default link behavior
                const introduction = link.getAttribute('data-intro');
                introText.textContent = introduction;
                introModal.style.display = "block";
            });
        });

        closeIntroModal.onclick = function () {
            introModal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target === introModal) {
                introModal.style.display = "none";
            }
        }
    </script>
 <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery.scrollex.min.js"></script>
    <script src="../assets/js/jquery.scrolly.min.js"></script>
    <script src="../assets/js/browser.min.js"></script>
    <script src="../assets/js/breakpoints.min.js"></script>
    <script src="../assets/js/util.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>

<?php
include 'connections/db.php'; // Ensure this sets up $pdo

session_start();
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

// Handle form submission for adding or updating
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        // Add new entry
        $name = $_POST['name'];
        $role = $_POST['role'];
        $level = $_POST['level'];
        $introduction = $_POST['introduction']; // New introduction field

        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image_url = '../uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image_url);

            $sql = "INSERT INTO org_chart (name, role, image_url, level, introduction) VALUES (:name, :role, :image_url, :level, :introduction)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['name' => $name, 'role' => $role, 'image_url' => $image_url, 'level' => $level, 'introduction' => $introduction]);
        }

    } elseif (isset($_POST['update'])) {
        // Update existing entry
        $id = $_POST['id'];
        $name = $_POST['name'];
        $role = $_POST['role'];
        $level = $_POST['level'];
        $introduction = $_POST['introduction']; // New introduction field

        // Handle file upload for update
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image_url = '../../uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image_url);

            $sql = "UPDATE org_chart SET name = :name, role = :role, image_url = :image_url, level = :level, introduction = :introduction WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['name' => $name, 'role' => $role, 'image_url' => $image_url, 'level' => $level, 'introduction' => $introduction, 'id' => $id]);
        } else {
            // If no image is uploaded, update without changing the image
            $sql = "UPDATE org_chart SET name = :name, role = :role, level = :level, introduction = :introduction WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['name' => $name, 'role' => $role, 'level' => $level, 'introduction' => $introduction,  'id' => $id]);
        }

    } elseif (isset($_POST['delete'])) {
        // Delete entry
        $id = $_POST['id'];
        $sql = "DELETE FROM org_chart WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization</title>
    <link href="css/style.css" rel="stylesheet">
    <style>

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #026670; /* Dark Teal */
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #026670;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #f37748; /* Coral Orange */
        }

        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            .container {
                width: 90%;
                margin: 20px auto;
            }

            input[type="text"],
            input[type="number"],
            input[type="file"],
            textarea,
            input[type="submit"] {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 20px;
            }

            input[type="text"],
            input[type="number"],
            input[type="file"],
            textarea {
                padding: 8px;
                font-size: 14px;
            }

            input[type="submit"] {
                padding: 8px;
                font-size: 14px;
            }
        }
         /* Org chart styling */
         .org .chart {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .level {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .node {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 150px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .profile-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .role {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }

        .update-btn, 
        form button {
            background-color: #026670;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px 0;
        }

        .update-btn:hover,
        form button:hover {
            background-color: #f37748;
        }

        .connector {
            height: 20px;
            border-left: 2px solid #026670;
            margin: 0 auto;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            text-align: center;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
        }

        .close:hover {
            color: #f37748;
        }

        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            .container {
                width: 90%;
                margin: 20px auto;
            }

            .node {
                width: 120px;
            }

            .profile-image {
                width: 60px;
                height: 60px;
            }

            input[type="submit"],
            form button,
            .update-btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 20px;
            }

            .node {
                width: 100px;
            }

            .profile-image {
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>
<body>

<!-- Include Navbar -->
<?php include 'components/navbar.php'; ?>

<!-- Add Member Form Section -->
<section>
    <div class="container">
        <h2>Add Member</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Name" required>

            <label for="role">Role:</label>
            <input type="text" name="role" id="role" placeholder="Role" required>

            <label for="image">Profile Picture:</label>
            <input type="file" name="image" id="image" accept="image/*" required>

            <label for="level">Level:</label>
            <input type="number" name="level" id="level" placeholder="Level" required>

            <label for="introduction">Brief Introduction:</label>
            <textarea name="introduction" id="introduction" placeholder="Brief Introduction" required></textarea>

            <input type="submit" name="add" value="Add Member">
        </form>
    </div>
</section>

<section class="org">
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
                            echo '<input type="submit" class="update-btn" data-id="' . $entry['id'] . '" data-name="' . htmlspecialchars($entry['name']) . '" data-role="' . htmlspecialchars($entry['role']) . '" data-level="' . $entry['level'] . '" data-image="' . htmlspecialchars($entry['image_url']) . '" data-intro="' . htmlspecialchars($entry['introduction']) . '">';
                            echo '<form action="" method="POST" style="display:inline;">';
                            echo '<input type="hidden" name="id" value="' . $entry['id'] . '">';
                            echo '<input type="submit" name="delete" value="Delete">';
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
                <form id="updateForm" action="" method="POST" enctype="multipart/form-data">
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



</body>
</html>

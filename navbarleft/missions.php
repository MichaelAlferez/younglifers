<?php
include 'connections/db.php';

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ministry_id = $_POST['ministry_id'];

    // Delete the ministry from the database
    $stmt = $pdo->prepare("DELETE FROM ministries WHERE id = ?");
    $stmt->execute([$ministry_id]);

    // Redirect back to the admin page
    header('Location: missions.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Missions</title>
    <link href="css/style.css" rel="stylesheet">
    <style>
        /* Add some basic styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        section {
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            background-color: #ffffff; /* White background for sections */
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Light shadow */
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], 
        textarea, 
        input[type="file"],
        button {
            padding: 10px;
            border: 2px solid #026670; /* Dark Teal */
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            background-color: #026670; /* Dark Teal */
            color: white;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #f37748; /* Coral Orange */
        }

        .spotlight {
            display: flex;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            background-color: #f9f9f9; /* Light grey background for ministries */
        }

        .spotlight .image {
            width: 150px;
            overflow: hidden;
        }

        .spotlight .image img {
            width: 100%;
            height: auto;
        }

        .spotlight .content {
            padding: 10px;
            flex: 1;
        }

        .delete-button {
            background-color: #a82424; /* Red for delete */
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #d31d1d; /* Darker red on hover */
        }

        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
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
            text-decoration: none;
            cursor: pointer;
        }

        .modal-button {
            margin: 5px;
        }
        
        .ministries-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Adjusts to screen size */
    gap: 20px; /* Space between cards */
    margin-top: 20px;
}

.ministry-card {
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Light shadow */
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    border: 1px solid #ccc; /* Border for the card */
}

.ministry-card .image {
    height: 150px; /* Fixed height for images */
    overflow: hidden;
    border-bottom: 1px solid #ccc;
}

.ministry-card .image img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures image covers the div nicely */
}

.ministry-card .content {
    padding: 10px;
    flex: 1;
}

.ministry-card h2 {
    font-size: 1.25em;
    margin: 0 0 10px 0;
}

.ministry-card p {
    font-size: 1em;
    margin-bottom: 10px;
}

.ministry-card .delete-button {
    align-self: center;
    width: fit-content;
    padding: 5px 10px;
    background-color: #a82424; /* Red for delete */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 10px;
}

.ministry-card .delete-button:hover {
    background-color: #d31d1d; /* Darker red on hover */
}

    </style>
</head>
<body>
    <?php include 'components/navbar.php'; ?>

    <section>
        <h1>Add Ministry</h1>
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

<section id="two" class="wrapper alt style2">

    <div class="ministries-grid">
        <?php if (!empty($ministries)): ?>
            <?php foreach ($ministries as $ministry): ?>
                <div class="ministry-card">
                    <div class="image">
                        <img src="<?php echo htmlspecialchars($ministry['image']); ?>" alt="Ministry Image" />
                    </div>
                    <div class="content">
                        <h2><?php echo htmlspecialchars($ministry['title']); ?><br /></h2>
                        <p><?php echo htmlspecialchars($ministry['description']); ?></p>
                        <!-- Option to Delete Ministry -->
                        <button class="delete-button" data-id="<?php echo $ministry['id']; ?>">Delete</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No ministries added yet.</p>
        <?php endif; ?>
    </div>
</section>


    <!-- Modal Structure for Deleting -->
    <div id="delete-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Are you sure you want to delete this ministry?</p>
            <form id="delete-form" method="POST" action="">
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

    <script src="js/script.js"></script>
</body>
</html>

<?php
include '../connections/db.php'; // Ensure this sets up $pdo

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
            $image_url = '../uploads/' . basename($_FILES['image']['name']);
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

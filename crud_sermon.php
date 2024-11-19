<?php
include 'connections/db.php';

// Sermon CRUD Operations

// Create Sermon
function createSermon($title, $description, $image) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO sermons (title, description, image) VALUES (?, ?, ?)");
    return $stmt->execute([$title, $description, $image]);
}

// Read Sermons
function getSermons() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM sermons");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Update Sermon
function updateSermon($id, $title, $description, $image) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE sermons SET title = ?, description = ?, image = ? WHERE id = ?");
    return $stmt->execute([$title, $description, $image, $id]);
}

// Delete Sermon
function deleteSermon($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM sermons WHERE id = ?");
    return $stmt->execute([$id]);
}
?>

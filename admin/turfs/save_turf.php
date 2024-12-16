<?php
include '../../config.php'; // Adjust to your DB connection file
$conn = new DBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $turf_id = $_POST['turf_id'] ?? null;
    $turf_name = $_POST['turf_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    $image1 = null;
    $image2 = null;

    // Handle file uploads
    if (isset($_FILES['image']) && count($_FILES['image']['name']) > 0) {
        $upload_dir = 'uploads/turfs/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        foreach ($_FILES['image']['name'] as $key => $filename) {
            if ($key > 1) break; // Limit to 2 images
            $temp_name = $_FILES['image']['tmp_name'][$key];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $new_filename = uniqid("turf_", true) . '.' . $ext;
            $target_file = $upload_dir . $new_filename;

            if (move_uploaded_file($temp_name, $target_file)) {
                if ($key === 0) $image1 = $target_file;
                if ($key === 1) $image2 = $target_file;
            }
        }
    }

    // Insert or Update the database
    if ($turf_id) {
        $sql = "UPDATE `turfs` SET turf_name = ?, description = ?, price = ?, status = ?, image = ?, image_2 = ? WHERE turf_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsisi", $turf_name, $description, $price, $status, $image1, $image2, $turf_id);
    } else {
        $sql = "INSERT INTO `turfs` (turf_name, description, price, status, image, image_2) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsis", $turf_name, $description, $price, $status, $image1, $image2);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'turf_id' => $turf_id ?? $conn->insert_id]);
    } else {
        echo json_encode(['status' => 'failed', 'msg' => 'Database error.']);
    }

    $stmt->close();
    $conn->close();
}

<?php
session_start();

// Get recruiter_id from the session
$rId = isset($_SESSION['r_id']) ? $_SESSION['r_id'] : null;

if (!$rId) {
    echo "No recruiter ID provided!";
    exit;
}

// Include the database connection
include "../DB_Connection/DB_connection.php";

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $recruiter_img = $_FILES['recruiter_img'];

    // Ensure the Profile_img directory exists
    if (!is_dir('Profile_img')) {
        mkdir('Profile_img', 0777, true); // Create the directory if it doesn't exist
    }

    // Handle image upload if present
    if ($recruiter_img['error'] == 0) {
        $imagePath = 'Profile_img/' . basename($recruiter_img['name']);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($recruiter_img['tmp_name'], $imagePath)) {
            echo "File uploaded successfully.";
        } else {
            echo "Failed to upload the file.";
            exit;
        }
    } else {
        // If no file is uploaded, set imagePath to null (or keep previous image)
        $imagePath = null;
    }

    // Prepare the update query
    $query = "UPDATE recruiter SET fname = ?, lname = ?, address = ?, recruiter_img = ? WHERE r_id = ?";
    $stmt = $conn->prepare($query);

    // Bind parameters for the query
    $stmt->bind_param("ssssi", $fname, $lname, $address, $imagePath, $rId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Profile updated successfully!'); window.location.href = './Menu.php';</script>";
    } else {
        echo "<script>alert('No changes made to your profile.'); window.location.href = './Menu.php';</script>";
    }
    
}
?>
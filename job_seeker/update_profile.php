<?php
session_start();

// Get job_seeker ID from the session
$jsId = isset($_SESSION['js_id']) ? $_SESSION['js_id'] : null;

if (!$jsId) {
    echo "No job_seeker ID provided!";
    exit;
}

// Include the database connection
include "../DB_Connection/DB_connection.php";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mobile_number = $_POST['mobile_number'];
    $address = $_POST['address'];
    $experience_1 = $_POST['experience_1'];
    $experience_2 = $_POST['experience_2'];
    $experience_3 = $_POST['experience_3'];
    $interest_1 = $_POST['interest_1'];
    $interest_2 = $_POST['interest_2'];
    $interest_3 = $_POST['interest_3'];
    $job_seeker_img = $_FILES['job_seeker_img'];

    // Ensure the Profile_img directory exists
    if (!is_dir('Profile_img')) {
        mkdir('Profile_img', 0777, true); // Create the directory if it doesn't exist
    }

    // Handle image upload if present
    if ($job_seeker_img['error'] == 0) {
        $imagePath = 'Profile_img/' . basename($job_seeker_img['name']);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($job_seeker_img['tmp_name'], $imagePath)) {
            echo "File uploaded successfully.";
        } else {
            echo "Failed to upload the file.";
            exit;
        }
    } else {
        // If no file is uploaded, use the existing image or set it to null
        $imagePath = $job_seeker['job_seeker_img'];  // Retain the current image if no new one is uploaded
    }

    // Prepare the update query
    $query = "UPDATE job_seeker 
              SET fname = ?, lname = ?, mobile_number = ?, address = ?, 
                  experience_1 = ?, experience_2 = ?, experience_3 = ?, 
                  interest_1 = ?, interest_2 = ?, interest_3 = ?, 
                  job_seeker_img = ? 
              WHERE js_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssssssi", $fname, $lname, $mobile_number, $address, 
                     $experience_1, $experience_2, $experience_3, 
                     $interest_1, $interest_2, $interest_3, $imagePath, $jsId);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to a success page or show success message
        header("Location: Menu.php");
        exit;
    } else {
        echo "Error updating profile: " . $stmt->error;
    }
}

?>

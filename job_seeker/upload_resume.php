<?php
session_start();

// Include database connection file
require_once '../DB_Connection/DB_connection.php';

// Get job seeker ID from session
if (isset($_SESSION['js_id'])) {
    $js_id = $_SESSION['js_id'];
} else {
    echo "<script>alert('Session expired or not set.'); window.location.href='Menu.php';</script>";
    exit;
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['resume'])) {
    // Define allowed file type
    $allowedTypes = ['application/pdf'];
    $fileType = $_FILES['resume']['type'];
    
    // Check if the uploaded file is a PDF
    if (in_array($fileType, $allowedTypes)) {
        // Define upload directory
        $uploadDir = 'resume/';
        
        // Create the directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create the directory with proper permissions
        }

        // Define the path where the resume will be saved
        $fileName = basename($_FILES['resume']['name']);
        $filePath = $uploadDir . $fileName;

        // Check if file already exists
        if (file_exists($filePath)) {
            echo "<script>alert('File already exists. Please try again.'); window.location.href='Menu.php';</script>";
        } else {
            // Move the uploaded file to the desired directory
            if (move_uploaded_file($_FILES['resume']['tmp_name'], $filePath)) {
                // Save the file path in the database                
                $sql = "UPDATE job_seeker SET resume = ? WHERE js_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $filePath, $js_id);
                
                if ($stmt->execute()) {
                    echo "<script>alert('File uploaded and path saved successfully!'); window.location.href='Menu.php';</script>";
                } else {
                    echo "<script>alert('Error updating database. Please try again.'); window.location.href='Menu.php';</script>";
                }
                
                $stmt->close();
                $conn->close();
            } else {
                echo "<script>alert('Error uploading file. Please try again.'); window.location.href='Menu.php';</script>";
            }
        }
    } else {
        echo "<script>alert('Only PDF files are allowed!'); window.location.href='Menu.php';</script>";
    }
}
?>
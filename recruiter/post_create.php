<?php
session_start();
include "../DB_Connection/DB_connection.php";

// Ensure recruiter ID is available in the session
if (!isset($_SESSION['r_id'])) {
    header("Location: ../Login.php");
    exit();
}

$r_id = $_SESSION['r_id']; // Recruiter ID from the session

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize inputs
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $key_responsibilities = mysqli_real_escape_string($conn, $_POST['key_responsibilities']);
    $education_requirement = mysqli_real_escape_string($conn, $_POST['education_requirement']);
    $years_experience = mysqli_real_escape_string($conn, $_POST['years_experience']);
    $deadline = $_POST['deadline'];
    $job_type = mysqli_real_escape_string($conn, $_POST['job_type']);

    // Validate form data (optional)
    if (empty($title) || empty($description) || empty($location) || empty($key_responsibilities) || empty($job_type)) {
        echo "Please fill all required fields!";
        exit();
    }

    // Prepare SQL query to insert data into the job_post table
    $sql = "INSERT INTO job_post (recruiter_id, title, description, location, key_responsibilities, education_requirement, years_experience, deadline, job_type) 
            VALUES ('$r_id', '$title', '$description', '$location', '$key_responsibilities', '$education_requirement', '$years_experience', '$deadline', '$job_type')";

    // Execute the query and check for success
    if (mysqli_query($conn, $sql)) {
        // Success - Redirect to the dashboard or show success message
        echo "<script>alert('Job post created successfully!'); window.location.href = 'Menu.php';</script>";
        exit();
    } else {
        // Error - Show error message
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
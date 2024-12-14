<?php
session_start();
include('../DB_Connection/DB_connection.php');

// Check if post_id is provided in the URL
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    // Prepare query to fetch job details for the given post_id
    $query = "SELECT * FROM job_post WHERE post_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('Error preparing the query: ' . $conn->error); // Debugging: Show error if query preparation fails
    }

    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the job post is found
    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
    } else {
        echo "<p>Job post not found!</p>";
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p>No job post ID provided!</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Post Details</title>
    <link rel="stylesheet" href="./post_details.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <!-- Displaying job details -->
        <div class="job-details">
            <h2><?php echo htmlspecialchars($job['title']); ?></h2>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
            <p><strong>Job Type:</strong> <?php echo htmlspecialchars($job['job_type']); ?></p>
            <p><strong>Educational Requirement:</strong> <?php echo htmlspecialchars($job['education_requirement']); ?></p>
            <p><strong>Responsibilities:</strong> <?php echo nl2br(htmlspecialchars($job['key_responsibilities'])); ?></p>
            <p><strong>Years of Experience:</strong> <?php echo htmlspecialchars($job['years_experience']); ?> years</p>
            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
            <p><strong>Deadline:</strong> <?php echo htmlspecialchars($job['deadline']); ?></p>
        </div>
    </div>

</body>
</html>

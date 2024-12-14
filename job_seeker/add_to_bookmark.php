<?php
// Include the database connection
include "../DB_Connection/DB_connection.php";

// Start the session to retrieve session variables
session_start();

// Check if the session contains js_id (assuming logged-in user is a job seeker)
if (!isset($_SESSION['js_id'])) {
    // If no job seeker is logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Get the job post ID from the URL
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $js_id = $_SESSION['js_id']; // Get the job seeker ID from the session

    // Check if the job post is already bookmarked by the job seeker
    $check_sql = "SELECT * FROM bookmark WHERE job_seeker_id = ? AND job_post_id = ?";
    $stmt_check = $conn->prepare($check_sql);

    if ($stmt_check === false) {
        echo "<p>Error preparing the statement: " . $conn->error . "</p>";
        exit();
    }

    $stmt_check->bind_param("ii", $js_id, $post_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // If already bookmarked, show an alert
        echo "<script>alert('You have already bookmarked this job post.');</script>";
    } else {
        // Insert the new bookmark into the database
        $insert_sql = "INSERT INTO bookmark (job_seeker_id, job_post_id) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($insert_sql);

        if ($stmt_insert === false) {
            echo "<script>alert('Error preparing the statement: " . $conn->error . "');</script>";
            exit();
        }

        $stmt_insert->bind_param("ii", $js_id, $post_id);
        $stmt_insert->execute();

        if ($stmt_insert->affected_rows > 0) {
            // Successfully added to bookmarks
            echo "<script>alert('Job post has been added to your bookmarks.');</script>";
        } else {
            echo "<script>alert('Error adding the job post to bookmarks. Please try again later.');</script>";
        }

        // Close the statement
        $stmt_insert->close();
    }

    // Close the check statement
    $stmt_check->close();
} else {
    echo "<p>Invalid job post ID.</p>";
}

// Close the database connection
$conn->close();
?>
<!-- Redirect back to the parent node (previous page) after a short delay -->
<meta http-equiv="refresh" content="2;url=<?php echo htmlspecialchars($_SERVER['HTTP_REFERER']); ?>">
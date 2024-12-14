<?php
session_start();
include('../DB_Connection/DB_connection.php'); // include your database connection file

// Check if r_id is set in the session
if (!isset($_SESSION['r_id'])) {
    echo "You need to login to view the posts.";
    exit();
}

$r_id = $_SESSION['r_id'];

// Fetch job posts from the database
$query = "SELECT * FROM job_post WHERE recruiter_id = ?"; // Ensure recruiter_id column name matches your table
$stmt = $conn->prepare($query);

// Check if statement preparation is successful
if ($stmt === false) {
    die('Error preparing the query: ' . $conn->error); // Debugging: Show error if query preparation fails
}

// Bind parameters to the prepared statement
$stmt->bind_param("i", $r_id);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job Posts</title>
    <link rel="stylesheet" href="./post_list.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .table-container {
            max-height: 550px;
            /* Adjust height to fit approximately 10 rows */
            overflow-y: auto;
            /* Enable vertical scrolling */
            border: 1px solid #ddd;
            /* Optional: Add border around the table container */
        }

        .post-container {
            width: 100%;
            padding: 0 20px;
            /* Optional: Add padding if needed */
            box-sizing: border-box;
            /* Ensures padding is included in the width calculation */
        }
    </style>
</head>

<body>
    <div class="post-container">

        <!-- Job Post List -->
        <div class="table-container">
            <table class="job-post-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Job Title</th>
                        <th>Job Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $serial_no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $serial_no . "</td>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['job_type']) . "</td>";
                        echo "<td><button class='view-btn' onclick='viewJobDetails(" . $row['post_id'] . ")'>View</button></td>";
                        echo "</tr>";
                        $serial_no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function viewJobDetails(postId) {
            // Send the post_id to see_post_details.php via AJAX
            $.ajax({
                url: 'see_post_details.php',
                method: 'GET',
                data: {
                    post_id: postId
                },
                success: function(response) {
                    $('#content-area').html(response);
                },
                error: function(xhr, status, error) {
                    console.log('Error fetching job details: ' + error);
                }
            });
        }
    </script>
</body>

</html>
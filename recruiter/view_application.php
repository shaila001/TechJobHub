<?php
session_start();

// Include the database connection
include "../DB_Connection/DB_connection.php";

// Get the recruiter ID from the session
$r_id = $_SESSION['r_id'];

// Query to get all job posts for the recruiter
$sql = "SELECT jp.post_id, jp.title FROM job_post jp WHERE jp.recruiter_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmt->bind_param('i', $r_id); // 'i' indicates integer type
$stmt->execute();
$result = $stmt->get_result();
$job_posts = $result->fetch_all(MYSQLI_ASSOC);

// Prepare the applicant list
$applicants = [];

foreach ($job_posts as $job_post) {
    $post_id = $job_post['post_id'];

    // Query to get job seekers who applied for the job post
    $sql_applications = "SELECT a.job_seeker_id, a.created_at, js.fname, js.lname 
                         FROM application a
                         JOIN job_seeker js ON a.job_seeker_id = js.js_id
                         WHERE a.job_post_id = ?";
    $stmt_applications = $conn->prepare($sql_applications);

    if ($stmt_applications === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt_applications->bind_param('i', $post_id);
    $stmt_applications->execute();
    $result_applications = $stmt_applications->get_result();

    // Store the applications
    while ($application = $result_applications->fetch_assoc()) {
        $applicants[] = $application;
    }
}
?>


<!-- HTML to display the table -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .applicant-container {
            width: 80%;
            margin: 20px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .view-btn {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }

        .view-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="applicant-container">
        <h1>Job Applications</h1>

        <?php if (empty($job_posts)): ?>
            <p class="no-data">No job posts found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Applicant Name</th>
                        <th>Application Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($job_posts as $job_post): ?>
                        <?php
                        // Get the applicants for each job post
                        $sql_applications = "SELECT a.job_seeker_id, a.created_at, js.fname, js.lname
                                     FROM application a
                                     JOIN job_seeker js ON a.job_seeker_id = js.js_id
                                     WHERE a.job_post_id = ?";
                        $stmt_applications = $conn->prepare($sql_applications);
                        $stmt_applications->bind_param('i', $job_post['post_id']);
                        $stmt_applications->execute();
                        $result_applications = $stmt_applications->get_result();

                        // Check if applicants exist for this job post
                        if ($result_applications->num_rows > 0):
                            while ($application = $result_applications->fetch_assoc()):
                        ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($job_post['title']); ?></td>
                                    <td><?php echo htmlspecialchars($application['fname'] . ' ' . $application['lname']); ?></td>
                                    <td><?php echo htmlspecialchars(date('F j, Y', strtotime($application['created_at']))); ?></td>
                                    <td>
                                        <a href="#" class="view-btn"
                                            data-js-id="<?php echo $application['job_seeker_id']; ?>"
                                            data-post-id="<?php echo $job_post['post_id'];; ?>">View</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <script>
        $(document).ready(function() {
            // Event handler for the "View" button click
            $('.view-btn').click(function(e) {
                e.preventDefault(); // Prevent the default link behavior (page reload)

                // Get the job seeker ID from the data-js-id attribute
                var jsId = $(this).data('js-id');

                // Get the post_id from the data-post-id attribute
                var postId = $(this).data('post-id');

                // Make the AJAX request
                $.ajax({
                    url: 'view_applicant_details.php', // The file where applicant details are fetched
                    type: 'GET',
                    data: {
                        js_id: jsId, // Send js_id in the request
                        post_id: postId // Send post_id in the request
                    },
                    success: function(response) {
                        // Update the content area with the response from the server
                        $('#content-area').html(response);
                    },
                    error: function() {
                        alert('Error loading the Profile details');
                    }
                });
            });
        });
    </script>
</body>

</html>
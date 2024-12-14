<?php
// Include the database connection
include "../DB_Connection/DB_connection.php";

// Start the session
session_start();

// Check if the session contains js_id (job seeker)
if (!isset($_SESSION['js_id'])) {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit();
}

// Get the job seeker ID from the session
$js_id = $_SESSION['js_id'];

// Query to get the applied job posts for the job seeker
$sql = "SELECT a.app_id, a.created_at, a.job_post_id, jp.title AS job_title, c.name AS company_name
        FROM application a
        JOIN job_post jp ON a.job_post_id = jp.post_id
        JOIN company c ON jp.recruiter_id = c.recruiter_id
        WHERE a.job_seeker_id = ? ORDER BY a.created_at DESC";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo "<p>Error preparing the statement: " . $conn->error . "</p>";
    exit();
}

$stmt->bind_param("i", $js_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $applications = $result->fetch_all(MYSQLI_ASSOC); // Fetch all applications
} else {
    $applications = [];
}

// Close the prepared statement
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Job Applications</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
            font-size: 36px;
            color: #333;
            font-weight: bold;
        }

        .application-container {
            max-width: 900px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .application-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .application-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 6px;
        }

        .application-item:last-child {
            border-bottom: none;
        }

        .application-item .job-title {
            font-weight: bold;
            color: #333;
            font-size: 18px;
        }

        .application-item .company-name {
            color: #555;
            font-size: 16px;
        }

        .application-item .apply-date {
            color: #888;
            font-size: 14px;
        }

        .view-answers-btn {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .view-answers-btn:hover {
            background-color: #0056b3;
        }

        .status {
            font-size: 14px;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 12px;
        }

        .status.applied {
            background-color: #007bff;
            color: white;
        }

        .status.interview {
            background-color: #ffc107;
            color: white;
        }

        .status.rejected {
            background-color: #dc3545;
            color: white;
        }

        .status.hired {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>

<body>
    <h1>Your Job Applications</h1>
    <div class="application-container">
        <?php if (empty($applications)): ?>
            <p>No job applications found.</p>
        <?php else: ?>
            <ul class="application-list">
                <?php foreach ($applications as $application): ?>
                    <li class="application-item">
                        <div class="job-info">
                            <span class="job-title"><?= htmlspecialchars($application['job_title']) ?></span> | 
                            <span class="company-name"><?= htmlspecialchars($application['company_name']) ?></span> |
                            <span class="apply-date">Applied on: <?= date('Y-m-d', strtotime($application['created_at'])) ?></span>
                        </div>
                        <div class="status applied">Applied</div>
                        <a href="view_post.php?post_id=<?= $application['job_post_id'] ?>" class="view-answers-btn">View Application</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>

</html>

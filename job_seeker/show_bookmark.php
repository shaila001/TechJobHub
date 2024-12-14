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

// Query to get the bookmarked job posts
$sql = "SELECT bm.bm_id, jp.title, c.name AS company_name, bm.job_post_id
        FROM bookmark bm
        JOIN job_post jp ON bm.job_post_id = jp.post_id
        JOIN company c ON jp.recruiter_id = c.recruiter_id
        WHERE bm.job_seeker_id = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo "<p>Error preparing the statement: " . $conn->error . "</p>";
    exit();
}

$stmt->bind_param("i", $js_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $bookmarks = $result->fetch_all(MYSQLI_ASSOC); // Fetch all bookmarks
} else {
    $bookmarks = [];
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
    <title>Your Bookmarked Jobs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
    <style>
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .bookmark-container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .bookmark-list {
            list-style-type: none;
            padding: 0;
        }

        .bookmark-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .bookmark-item:last-child {
            border-bottom: none;
        }

        .bookmark-item .job-title {
            font-weight: bold;
            color: #333;
        }

        .bookmark-item .company-name {
            color: #555;
        }

        .view-btn {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
        }

        .view-btn:hover {
            background-color: #0056b3;
        }

        .no-bookmarks {
            text-align: center;
            font-size: 18px;
            color: #666;
        }
    </style>
</head>

<body>

    <h1>Your Bookmarked Jobs</h1>

    <div class="bookmark-container">
        <?php if (count($bookmarks) > 0): ?>
            <ul class="bookmark-list">
                <?php foreach ($bookmarks as $bookmark): ?>
                    <li class="bookmark-item">
                        <div>
                           <strong>Job Titile: </strong> <span class="job-title"><?php echo htmlspecialchars($bookmark['title']); ?></span><br>
                            <strong>Company Name: </strong><span class="company-name"><?php echo htmlspecialchars($bookmark['company_name']); ?></span>
                        </div>
                        <a href="view_post.php?post_id=<?php echo $bookmark['job_post_id']; ?>" class="view-btn">View Job</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="no-bookmarks">You have no bookmarked jobs yet...</p>
        <?php endif; ?>
    </div>

</body>

</html>



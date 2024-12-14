<?php
include "../DB_Connection/DB_connection.php";

session_start();

if (!isset($_SESSION['js_id'])) {
    header("Location: login.php");
    exit();
}

// Get the post_id from the URL
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $sql = "SELECT * FROM job_post WHERE post_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "<p>Error preparing the statement: " . $conn->error . "</p>";
        exit();
    }

    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $job_result = $stmt->get_result();

    if ($job_result->num_rows > 0) {
        $job_post = $job_result->fetch_assoc(); // Fetch job post details
    } else {
        echo "<p>Job post not found.</p>";
        exit();
    }

    // Get the recruiter_id from the job post to fetch the company details
    $recruiter_id = $job_post['recruiter_id'];

    // Query the company details using the recruiter_id
    $sql_company = "SELECT * FROM company WHERE recruiter_id = ?";
    $stmt_company = $conn->prepare($sql_company);

    if ($stmt_company === false) {
        echo "<p>Error preparing the statement: " . $conn->error . "</p>";
        exit();
    }

    $stmt_company->bind_param("i", $recruiter_id);
    $stmt_company->execute();
    $company_result = $stmt_company->get_result();

    if ($company_result->num_rows > 0) {
        $company = $company_result->fetch_assoc(); // Fetch company details
    } else {
        echo "<p>Company details not found.</p>";
        exit();
    }

    // Close the prepared statements
    $stmt->close();
    $stmt_company->close();
} else {
    echo "<p>Invalid post ID.</p>";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Post Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./view_post.css">
    <style>
        /* Reset some styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            color: #333;
            padding: 20px;
        }

        /* Back Button Styling */
        .back-btn {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            font-size: 18px;
            color: #007bff;
            margin-bottom: 20px;
            padding: 5px 15px;
            background-color: #f0f8ff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #d6e9f7;
        }

        .back-btn i {
            margin-right: 8px;
        }

        /* Main container for job details */
        .job-post-details {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Section titles */
        .section-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        /* Info sections */
        .info-section {
            margin-bottom: 30px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .info-item i {
            font-size: 24px;
            color: #007bff;
            margin-right: 15px;
        }

        .info-item p {
            font-size: 16px;
            line-height: 1.6;
        }

        .info-item a {
            color: #007bff;
            text-decoration: none;
        }

        .info-item a:hover {
            text-decoration: underline;
        }

        /* Job info and company info specific styling */
        .job-info,
        .company-info {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .job-info .info-item {
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .job-info .info-item:last-child,
        .company-info .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .job-info p,
        .company-info p {
            font-size: 16px;
            color: #555;
        }

        /* A little extra spacing for top-level content */
        h2 {
            font-size: 30px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }

        /* General Button Styling */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin: 10px 10px;
        }

        /* Add to Bookmark Button */
        .bookmark-btn {
            background-color: #007bff;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }

        .bookmark-btn:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        .bookmark-btn i {
            margin-right: 8px;
        }

        /* Apply Now Button */
        .apply-btn {
            background-color: #28a745;
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }

        .apply-btn:hover {
            background-color: #218838;
            transform: translateY(-3px);
        }

        .apply-btn i {
            margin-right: 8px;
        }

        /* Action Buttons Container */
        .action-buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- Back Button -->
    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Listings</a>

    <div class="job-post-details">
        <h2>Job Post Details</h2>

        <!-- Job Post Information -->
        <div class="info-section job-info">
            <h3 class="section-title">Job Information</h3>
            <div class="info-item">
                <i class="fas fa-briefcase"></i>
                <p><strong>Job Title:</strong> <?php echo htmlspecialchars($job_post['title']); ?></p>
            </div>
            <div class="info-item">
                <i class="fas fa-graduation-cap"></i>
                <p><strong>Education Requirement:</strong> <?php echo htmlspecialchars($job_post['education_requirement']); ?></p>
            </div>
            <div class="info-item">
                <i class="fas fa-calendar-alt"></i>
                <p><strong>Deadline:</strong> <?php echo htmlspecialchars($job_post['deadline']); ?></p>
            </div>
            <div class="info-item">
                <i class="fas fa-file-alt"></i>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($job_post['description'])); ?></p>
            </div>
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($job_post['location']); ?></p>
            </div>
            <div class="info-item">
                <i class="fas fa-cogs"></i>
                <p><strong>Job Type:</strong> <?php echo htmlspecialchars($job_post['job_type']); ?></p>
            </div>
            <div class="info-item">
                <i class="fas fa-briefcase"></i>
                <p><strong>Years of Experience:</strong> <?php echo htmlspecialchars($job_post['years_experience']); ?> years</p>
            </div>
            <div class="info-item">
                <i class="fas fa-tasks"></i>
                <p><strong>Key Responsibilities:</strong> <?php echo nl2br(htmlspecialchars($job_post['key_responsibilities'])); ?></p>
            </div>
        </div>

        <!-- Company Information -->
        <div class="info-section company-info">
            <h3 class="section-title">Company Information</h3>
            <div class="info-item">
                <i class="fas fa-building"></i>
                <p><strong>Company Name:</strong> <?php echo htmlspecialchars($company['name']); ?></p>
            </div>
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($company['address'])); ?></p>
            </div>
            <div class="info-item">
                <i class="fas fa-info-circle"></i>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($company['description'])); ?></p>
            </div>
            <div class="info-item">
                <i class="fas fa-link"></i>
                <p><strong>Website:</strong> <a href="<?php echo htmlspecialchars($company['website']); ?>" target="_blank"><?php echo htmlspecialchars($company['website']); ?></a></p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="add_to_bookmark.php?post_id=<?php echo $post_id; ?>" class="btn bookmark-btn"><i class="fas fa-bookmark"></i> Add to Bookmark</a>
            <a href="apply_job.php?post_id=<?php echo $post_id; ?>" class="btn apply-btn"><i class="fas fa-paper-plane"></i> Apply Now</a>
        </div>
    </div>


</body>

</html>
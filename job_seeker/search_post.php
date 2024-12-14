<?php
include "../DB_Connection/DB_connection.php";

if (isset($_GET['category'])) {
    $category = $_GET['category'];

    // Query job posts related to the selected category, now selecting post_id as well
    $sql = "SELECT job_post.post_id, job_post.title, company.name FROM job_post
            JOIN company ON job_post.recruiter_id = company.recruiter_id
            WHERE job_post.title LIKE ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Check if the preparation was successful
    if ($stmt === false) {
        echo "<p>Error preparing the statement: " . $conn->error . "</p>";
        exit();
    }

    $category = "%" . $category . "%"; // Search for titles containing the category
    $stmt->bind_param("s", $category); // Bind the category to the prepared statement
    $stmt->execute();
    $result = $stmt->get_result();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Job Listings</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="./search_post.css">
        <link rel="icon" type="image/png" href="../images/logo.png">
    </head>

    <body>
        <!-- Back Button -->
        <a href="./Dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back </a>
        <!-- <a href="parent-page.php" class="back-btn">Back</a> -->

        <h2>Job Listings for '<?php echo htmlspecialchars($_GET['category']); ?>'</h2>

        <?php if ($result->num_rows > 0): ?>
            <div class="job-listings-container">
                <!-- Column Headers -->
                <div class="list-header">
                    <span>Serial No.</span>
                    <span>Job Title</span>
                    <span>Company Name</span>
                    <span>Action</span>
                </div>
                <?php
                $serial = 1;
                while ($row = $result->fetch_assoc()): ?>
                    <div class="job-item">
                        <span class="serial-number"><?php echo $serial++; ?></span>
                        <span class="job-title"><?php echo htmlspecialchars($row['title']); ?></span>
                        <span class="company-name"><?php echo htmlspecialchars($row['name']); ?></span>
                        <a href="view_post.php?post_id=<?php echo $row['post_id']; ?>" class="view-btn"><i class="fas fa-eye"></i> View</a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No job listings found for '<?php echo htmlspecialchars($_GET['category']); ?>'.</p>
        <?php endif; ?>

    <?php
    $stmt->close();
}
$conn->close();
    ?>
    </body>

    </html>
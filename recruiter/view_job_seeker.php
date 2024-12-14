<?php

include "./header.php";
$r_id = $_SESSION['r_id']; // Recruiter ID

// Include the database connection
include "../DB_Connection/DB_connection.php";

// Check if the js_id is set in the URL
if (!isset($_GET['js_id']) || empty($_GET['js_id'])) {
    die('Job seeker ID not provided!');
}

$js_id = $_GET['js_id']; // Get the job seeker ID from the query string

// Query to get the job seeker's details based on js_id
$sql = "SELECT js.fname, js.lname, js.email, js.address, js.mobile_number, js.resume, js.job_seeker_img
        FROM job_seeker js 
        WHERE js.js_id = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmt->bind_param('i', $js_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $job_seeker = $result->fetch_assoc();
} else {
    die('No job seeker found with this ID!');
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            font-family: 'Roboto', sans-serif;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 70%;
            max-width: 800px;
            margin: 0 auto;
        }

        .job-seeker-card {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .job-seeker-card img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-right: 20px;
        }

        .job-seeker-card h2 {
            font-size: 24px;
            margin: 0;
        }

        .details {
            margin-top: 20px;
        }

        .details p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }

        .details .label {
            font-weight: bold;
        }

        .details .download-btn {
            display: inline-flex;
            align-items: center;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .details .download-btn:hover {
            background-color: #45a049;
        }

        .details i {
            margin-right: 8px;
        }

        .button-container {
            text-align: center;
            margin-top: 30px;
        }

        .button-container .back-btn {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .button-container .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="job-seeker-card">
            <img src="../job_seeker/<?php echo $job_seeker['job_seeker_img']; ?>" alt="<?php echo $job_seeker['fname'] . ' ' . $job_seeker['lname']; ?>">
            <div>
                <h2><?php echo $job_seeker['fname'] . ' ' . $job_seeker['lname']; ?></h2>
                <p><strong>Email:</strong> <?php echo $job_seeker['email']; ?></p>
                <p><strong>Mobile:</strong> <?php echo $job_seeker['mobile_number']; ?></p>
            </div>
        </div>

        <div class="details">
            <p>
                <span class="label">Resume:</span>
                <a href="../job_seeker/<?php echo $job_seeker['resume']; ?>"
                    download="<?php echo $job_seeker['resume']; ?>"
                    class="download-btn"
                    title="Download Resume">
                    <i class="fas fa-download"></i> Download Resume
                </a>
            </p>
        </div>

        <div class="button-container">
            <a href="javascript:void(0);" class="back-btn" onclick="goBack()">Back to Previous Page</a>
        </div>
    </div>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>


</body>

</html>
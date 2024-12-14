<?php
// Start the session
session_start();
$r_id = $_SESSION['r_id'];
// Include the database connection
include "../DB_Connection/DB_connection.php";

// Check if the js_id is set in the URL
if (!isset($_GET['js_id']) || empty($_GET['js_id']) || !isset($_GET['post_id']) || empty($_GET['post_id'])) {
    die('Job seeker ID or Post ID not provided!');
}

$js_id = $_GET['js_id']; // Get the job seeker ID from the query string
$post_id = $_GET['post_id']; // Get the job post ID from the query string

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .details-container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .profile-card {
            display: flex;
            align-items: center;
            justify-content: space-around;
            margin-top: 20px;
        }

        .profile-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #3498db;
        }

        .profile-info {
            flex: 1;
            padding: 20px;
        }

        .profile-info h3 {
            font-size: 24px;
            color: #2980b9;
            margin-bottom: 10px;
        }

        .profile-info p {
            font-size: 18px;
            margin: 5px 0;
        }

        .resume-link {
            display: inline-block;
            margin-top: 15px;
            background-color: #2980b9;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .resume-link:hover {
            background-color: #3498db;
        }

        .button-back {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .button-back:hover {
            background-color: #2ecc71;
        }

        .btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>

<body>

    <div class="details-container">
        <h2>Applicant Details</h2>

        <div class="profile-card">
            <?php if (!empty($job_seeker['job_seeker_img'])): ?>
                <img src="../job_seeker/<?php echo htmlspecialchars($job_seeker['job_seeker_img']); ?>" alt="Job Seeker Image">
            <?php else: ?>
                <img src="https://via.placeholder.com/150" alt="Default Image">
            <?php endif; ?>

            <div class="profile-info">
                <h3><?php echo htmlspecialchars($job_seeker['fname'] . ' ' . $job_seeker['lname']); ?></h3>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($job_seeker['email']); ?></p>
                <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($job_seeker['mobile_number']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($job_seeker['address']); ?></p>
                <a href="../job_seeker/<?php echo htmlspecialchars($job_seeker['resume']); ?>"
                    class="resume-link"
                    download="Resume_<?php echo htmlspecialchars($job_seeker['fname'] . '_' . $job_seeker['lname']); ?>">
                    <i class="fas fa-download"></i> Download Resume
                </a>
                <button id="interviewBtn" class="btn" onclick="selectForInterview(<?php echo $r_id; ?>, <?php echo $js_id; ?>, <?php echo $post_id; ?>)">Select for Interview</button>


            </div>
        </div>
    </div>
    <script>
        function selectForInterview(r_id, js_id, post_id) {
            $.ajax({
                url: 'select_for_interview.php',
                type: 'POST',
                data: {
                    r_id: r_id,
                    js_id: js_id,
                    post_id: post_id
                },
                success: function(response) {
                    alert(response); // Show success/error message
                    // Disable the button after clicking
                    $('#interviewBtn').prop('disabled', true);
                },
                error: function() {
                    alert("Error occurred while scheduling the interview.");
                }
            });
        }
    </script>

</body>

</html>
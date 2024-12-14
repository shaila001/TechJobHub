<?php
session_start();

// Include database connection
require_once '../DB_Connection/DB_connection.php';

// Get job seeker ID from session
if (isset($_SESSION['js_id'])) {
    $js_id = $_SESSION['js_id'];
} else {
    echo "<script>alert('Session expired or not set.'); window.location.href='Menu.php';</script>";
    exit;
}

// Fetch resume file path from the database
$sql = "SELECT resume FROM job_seeker WHERE js_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $js_id);
$stmt->execute();
$stmt->bind_result($resumePath);
$stmt->fetch();
$stmt->close();

// Check if resume exists
if (!$resumePath || !file_exists($resumePath)) {
    echo "<script>alert('No resume found for this job seeker.'); window.location.href='Menu.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Resume</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .view-container {
            text-align: center;
            margin: auto;
            margin-top: 35px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 60%;
            padding: 40px;
        }
        h1 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .button-group {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .button {
            background-color: #3498db;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        .button:hover {
            background-color: #2980b9;
            transform: translateY(-3px);
        }
        .button i {
            margin-right: 10px;
        }
        .button-group a {
            text-decoration: none;
        }
        .button:active {
            transform: translateY(2px);
        }
        .error-message {
            color: red;
            margin-top: 20px;
        }
        .resume-preview {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .embed-container {
            max-width: 100%;
            width: 100%;
            height: 500px;
            border: none;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="view-container">
        <h1>View Your Resume</h1>
        
        <!-- Display buttons -->
        <div class="button-group">
            <a href="view_resume.php?preview=true" class="button"><i class="fas fa-eye"></i>Preview Resume</a>
            <a href="<?php echo $resumePath; ?>" class="button" download><i class="fas fa-download"></i>Download Resume</a>
        </div>

        <!-- Display PDF Preview if requested -->
        <?php
        if (isset($_GET['preview']) && $_GET['preview'] == 'true') {
            echo "<div class='resume-preview'>";
            echo "<embed src='" . $resumePath . "' class='embed-container' />";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>

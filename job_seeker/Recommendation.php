<?php
session_start();
include "../DB_Connection/DB_connection.php";

// Ensure that the user is logged in and the session is valid
if (!isset($_SESSION['js_id'])) {
    header("Location: login.php");
    exit();
}

$js_id = $_SESSION['js_id'];  // Get job seeker ID

// Define the categories and their corresponding job titles
$categories = [
    'Design and Creativity' => [
        'Graphic Designer', 'UI Designer', 'Motion Graphics Designer', '3D Animator',
        'Product Designer', 'Interaction Designer', 'UX Research'
    ],
    'Software Development and Engineering' => [
        'Back-end Developer', 'Full Stack Developer', 'Embedded Systems Developer', 'Game Developer (2D/3D)',
        'Mobile Application Developer', 'AR/VR Developer', 'Firmware Developer'
    ],
    'AI, Data, and Machine Learning' => [
        'Data Scientist', 'Junior NLP Engineer', 'AI/ML Engineer', 'Computer Vision Engineer',
        'Generative AI Specialist', 'Data Engineer', 'AI Ethics Specialist', 'Big Data Analyst'
    ],
    'Robotics and IoT' => [
        'Robotics Engineer', 'IoT Solutions Architect', 'Edge AI Developer', 'Control Systems Engineer', 'Autonomous Systems Engineer'
    ],
    'Networking and Cloud' => [
        'Network Engineer', 'Cloud Engineer', 'Systems Administrator', 'Cloud Solutions Architect',
        'Infrastructure Engineer', 'Wireless Network Specialist'
    ],
    'Quality Assurance and Testing' => [
        'Quality Assurance Tester', 'Test Automation Engineer', 'Penetration Tester (Ethical Hacker)', 'Load and Performance Tester'
    ],
    'Web and Mobile Technologies' => [
        'Front-end Developer', 'Progressive Web App (PWA) Developer', 'API Developer', 'Low-Code/No-Code Developer'
    ],
    'Business and Project Management' => [
        'Scrum Master', 'Technical Program Manager', 'IT Business Analyst', 'Product Owner'
    ]
];


// Retrieve interests for the user (interest_1, interest_2, interest_3)
$sql = "SELECT interest_1, interest_2, interest_3 FROM job_seeker WHERE js_id = ?";
$stmt = $conn->prepare($sql);

// Check if the prepare method works
if ($stmt === false) {
    die("Error preparing the SQL statement: " . $conn->error);
}

$stmt->bind_param("i", $js_id);
$stmt->execute();
$result = $stmt->get_result();
$user_interests = $result->fetch_assoc();
$stmt->close();

// Use the first interest for matching jobs
$interests = array_filter([$user_interests['interest_1'], $user_interests['interest_2'], $user_interests['interest_3']]);

// Get job posts that match the user's interests
$matching_jobs = [];
foreach ($interests as $interest) {
    if (isset($categories[$interest])) {
        $titles = implode("','", $categories[$interest]);
        $sql = "SELECT jp.post_id, jp.title, jp.recruiter_id, jp.description 
                FROM job_post jp
                WHERE jp.title IN ('$titles')";
        $result = $conn->query($sql);
        
        while ($row = $result->fetch_assoc()) {
            $matching_jobs[] = $row;
        }
    }
}

// Fetch company name for each recruiter_id
$companies = [];
foreach ($matching_jobs as $job) {
    $recruiter_id = $job['recruiter_id'];
    if (!isset($companies[$recruiter_id])) {
        $sql = "SELECT name FROM company WHERE recruiter_id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            die("Error preparing the SQL statement for company: " . $conn->error);
        }
        
        $stmt->bind_param("i", $recruiter_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $company = $result->fetch_assoc();
        $companies[$recruiter_id] = $company ? $company['name'] : 'Unknown';
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Recommendations</title>
    <!-- <link rel="stylesheet" href="Recommendation.css"> -->
     <style>
        /* Recommendation.css */

/* Recommendation.css */

/* General Styles */
/* General Styles */
body {
    font-family: 'Roboto', sans-serif;
    background-color: #e9eef5;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Title */
h1.recommendation-title {
    text-align: center;
    font-size: 3rem;
    color: #2c3e50;
    margin-bottom: 40px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    padding-bottom: 10px;
    margin-top: 20px;
    width: 100%;
    position: relative;
    display: inline-block;
}

h1.recommendation-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background-color: #3498db;
    border-radius: 2px;
}

/* Job Cards Container */
.job-cards-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
    padding: 0 20px;
    max-width: 1200px;
    margin: 0 auto;
}

/* Individual Job Card */
.job-card {
    background: linear-gradient(145deg, #ffffff, #f0f4f9);
    border-radius: 15px;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1), -5px -5px 15px rgba(255, 255, 255, 0.7);
    overflow: hidden;
    transition: all 0.3s ease-in-out;
    border: none;
    position: relative;
}

.job-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

.job-card-header {
    background: #3498db;
    color: white;
    padding: 20px;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}

.job-title {
    font-size: 1.8rem;
    margin: 0;
    font-weight: bold;
    line-height: 1.4;
}

.company-name {
    font-size: 1.2rem;
    margin-top: 8px;
    font-style: italic;
    opacity: 0.9;
}

/* Job Description */
.job-description {
    padding: 20px;
    font-size: 1.1rem;
    color: #444;
    line-height: 1.7;
    font-weight: 400;
    background-color: #fdfdfd;
}

/* View Button */
.view-btn {
    display: inline-block;
    padding: 12px 25px;
    font-size: 1rem;
    background: linear-gradient(90deg, #3498db, #2c3e50);
    color: #fff;
    text-decoration: none;
    border-radius: 25px;
    text-align: center;
    margin: 15px 20px 20px;
    transition: all 0.3s ease-in-out;
    font-weight: bold;
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
}

.view-btn:hover {
    background: linear-gradient(90deg, #2c3e50, #3498db);
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(44, 62, 80, 0.4);
}

/* Responsive Design */
@media (max-width: 768px) {
    .job-cards-container {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 480px) {
    .job-cards-container {
        grid-template-columns: 1fr;
    }

    h1.recommendation-title {
        font-size: 2.5rem;
    }
}



     </style>
</head>
<body>

    <h1 class="recommendation-title">Job Recommendations</h1>
    
    <div class="job-cards-container">
        <?php foreach ($matching_jobs as $job): ?>
            <div class="job-card">
                <div class="job-card-header">
                    <h3 class="job-title"><?php echo htmlspecialchars($job['title']); ?></h3>
                    <p class="company-name"><?php echo htmlspecialchars($companies[$job['recruiter_id']]); ?></p>
                </div>
                <p class="job-description"><?php echo htmlspecialchars($job['description']); ?></p>
                <a href="view_post.php?post_id=<?php echo $job['post_id']; ?>" class="view-btn">View</a>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>

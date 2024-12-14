<?php
session_start();
include "../DB_Connection/DB_connection.php";

// Get recruiter ID from the session
$r_id = $_SESSION['r_id'];

// Initialize counts
$job_posts_count = 0;
$applications_count = 0;
$interviews_count = 0;

// Query to count active job posts for the recruiter
$sql_job_posts = "SELECT COUNT(*) AS job_posts_count FROM job_post WHERE recruiter_id = ?";
$stmt_job_posts = $conn->prepare($sql_job_posts);
$stmt_job_posts->bind_param("i", $r_id);
$stmt_job_posts->execute();
$result_job_posts = $stmt_job_posts->get_result();
if ($row = $result_job_posts->fetch_assoc()) {
    $job_posts_count = $row['job_posts_count'];
}

// Query to count applications for the recruiter's job posts
$sql_applications = "SELECT COUNT(*) AS applications_count 
                     FROM application a 
                     JOIN job_post jp ON a.job_post_id = jp.post_id 
                     WHERE jp.recruiter_id = ?";
$stmt_applications = $conn->prepare($sql_applications);
$stmt_applications->bind_param("i", $r_id);
$stmt_applications->execute();
$result_applications = $stmt_applications->get_result();
if ($row = $result_applications->fetch_assoc()) {
    $applications_count = $row['applications_count'];
}

// Query to count pending interviews for the recruiter
$sql_interviews = "SELECT COUNT(*) AS interviews_count FROM interview WHERE r_id = ? AND status = 'pending'";
$stmt_interviews = $conn->prepare($sql_interviews);
$stmt_interviews->bind_param("i", $r_id);
$stmt_interviews->execute();
$result_interviews = $stmt_interviews->get_result();
if ($row = $result_interviews->fetch_assoc()) {
    $interviews_count = $row['interviews_count'];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TechJobHub</title>
    <link rel="stylesheet" href="../css/Menu_options.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="../js/Menu_options.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/png" href="./images/logo.png">

    <style>
        .span {
            margin-left: 32px;
            /* Adds space between the icon and text */
        }

        a {
            text-decoration: none;
        }

        a:hover {
            color: inherit;
        }

        /* General Container */
        .welcome-container {
            background-color: #f4f4f4;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-family: Arial, sans-serif;
        }

        /* Welcome Header */
        .welcome-header h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .welcome-header h2 span {
            color: #4CAF50;
            font-weight: bold;
        }

        .welcome-header p {
            font-size: 18px;
            color: #555;
            margin-top: 5px;
        }

        .welcome-header i {
            color: #4CAF50;
            margin-right: 5px;
        }

        /* Stats Cards */
        .stats-cards {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .card {
            background-color: #fff;
            width: 30%;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card .icon {
            font-size: 40px;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .card h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 16px;
            color: #777;
        }

        .card p span {
            font-size: 24px;
            color: #4CAF50;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar" style="height: 150%;">
            <a href="./Dashboard.php">
                <div class="logo">
                    <img src="../images/logo.png" alt="TechJobHub" />
                    <h1>TechJobHub</h1>
                </div>
            </a>
            <ul class="nav-links">
                <!-- This is Profile show -->
                <li class="" id="profile-btn">
                    <a href="javascript:void(0);">
                        <i class="fas fa-user-circle"></i>
                        <span class="span">Profile</span>
                    </a>
                </li>
                <!-- This is for Company -->
                <li class="" id="company-btn">
                    <a href="javascript:void(0);">
                        <i class="fas fa-building"></i>
                        <!-- Building icon for Company -->
                        <span class="span">Company</span>
                    </a>
                </li>

                <!-- This is for Create Post -->
                <li class="" id="create-post-btn">
                    <a href="javascript:void(0);">
                        <i class="fas fa-pencil-alt"></i>
                        <!-- You can change this icon to something appropriate -->
                        <span class="span">Create Post</span>
                    </a>
                </li>

                <!-- This is for See Created Posts -->
                <li class="" id="see-posts-btn">
                    <a href="javascript:void(0);">
                        <i class="fas fa-list"></i>
                        <!-- List icon for seeing posts -->
                        <span class="span">See Created Posts</span>
                    </a>
                </li>
                <!-- This is for Employee -->
                <li class="" id="employee-btn">
                    <a href="javascript:void(0);">
                        <i class="fas fa-user"></i>
                        <span class="span">See Applications</span> <!-- Text for Employee -->
                    </a>
                </li>
                <!-- This is for Set Interview -->
                <li class="" id="set-interview-btn">
                    <a href="javascript:void(0);">
                        <i class="fas fa-calendar-check"></i> <!-- You can use a calendar or check icon -->
                        <span class="span">Set Interview</span> <!-- Text for Set Interview -->
                    </a>
                </li>


                <!-- This is for Logout -->
                <li class="" id="logout-btn">
                    <a href="../logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <!-- Sign-out icon for logout -->
                        <span class="span">Logout</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main-content">
            <div class="top-nav">
                <div class="topbutton">
                    <a href="./Dashboard.php">Home</a>
                    <a href="../about_us.php">About Us</a>
                    <a href="../contact.php">Contact</a>
                </div>
            </div>
            <!-- Main content area -->
            <div id="content-area">
                <div class="welcome-container">
                    <div class="welcome-header">
                        <h2><i class="fas fa-briefcase"></i> Welcome to <span>TechJobHub!</span></h2>
                        <p><i class="fas fa-chart-line"></i> Here's a quick overview of your activity:</p>
                    </div>

                    <div class="stats-cards">
                        <div class="card">
                            <div class="icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h3>Job Posts</h3>
                            <p><span><?php echo $job_posts_count; ?></span> Active</p>
                        </div>
                        <div class="card">
                            <div class="icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <h3>Applications</h3>
                            <p><span><?php echo $applications_count; ?></span> Received</p>
                        </div>
                        <div class="card">
                            <div class="icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h3>Interviews</h3>
                            <p><span><?php echo $interviews_count; ?></span> Scheduled</p>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>

    <!-- jQuery script for AJAX dynamic loading -->
    <script>
        $(document).ready(function() {
            // When profile button is clicked
            $('#profile-btn').click(function() {
                loadContent('profile.php'); // Load profile page
            });

            // When company button is clicked
            $('#company-btn').click(function() {
                loadContent('company.php'); // Load company page
            });

            // When create post button is clicked
            $('#create-post-btn').click(function() {
                loadContent('./Create_post.php'); // Load create post page
            });

            // When see posts button is clicked
            $('#see-posts-btn').click(function() {
                loadContent('./see_post_list.php'); // Load see created posts page
            });
            // When see employee-btn button is clicked
            $('#employee-btn').click(function() {
                loadContent('./view_application.php'); // Load see created posts page
            });
            // When see set-interview-btn button is clicked
            $('#set-interview-btn').click(function() {
                loadContent('./view_interview_list.php'); // Load see created posts page
            });
            // Function to load content dynamically into the content area
            function loadContent(page) {
                $.ajax({
                    url: page,
                    type: 'GET',
                    success: function(response) {
                        $('#content-area').html(response);
                    },
                    error: function() {
                        $('#content-area').html('<p>Error loading content.</p>');
                    }
                });
            }
        });
    </script>
</body>

</html>
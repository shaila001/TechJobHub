<?php
session_start();
include "../DB_Connection/DB_connection.php";

$js_id = $_SESSION['js_id'];
$bookmarks_count = 0;
$applications_count = 0;
$interviews_count = 0;

$sql_bookmarks = "SELECT COUNT(*) AS bookmarks_count FROM bookmark WHERE job_seeker_id = ?";
$stmt_bookmarks = $conn->prepare($sql_bookmarks);
$stmt_bookmarks->bind_param("i", $js_id);
$stmt_bookmarks->execute();
$result_bookmarks = $stmt_bookmarks->get_result();
if ($row = $result_bookmarks->fetch_assoc()) {
  $bookmarks_count = $row['bookmarks_count'];
}

$sql_applications = "SELECT COUNT(*) AS applications_count FROM application WHERE job_seeker_id = ?";
$stmt_applications = $conn->prepare($sql_applications);
$stmt_applications->bind_param("i", $js_id);
$stmt_applications->execute();
$result_applications = $stmt_applications->get_result();
if ($row = $result_applications->fetch_assoc()) {
  $applications_count = $row['applications_count'];
}

$sql_interviews = "SELECT COUNT(*) AS interviews_count FROM interview WHERE js_id = ?";
$stmt_interviews = $conn->prepare($sql_interviews);
$stmt_interviews->bind_param("i", $js_id);
$stmt_interviews->execute();
$result_interviews = $stmt_interviews->get_result();
if ($row = $result_interviews->fetch_assoc()) {
  $interviews_count = $row['interviews_count'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TechJobHub</title>
  <link rel="stylesheet" href="../css/Menu_options.css" />
  <link rel="icon" type="image/png" href="../images/logo.png">


  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <script src="../js/Menu_options.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="icon" type="image/png" href="./images/logo.png">

  <style>
    .span {
      margin-left: 32px;
    }

    a {
      text-decoration: none;
    }

    a:hover {
      color: inherit;
    }

    .welcome-container {
      text-align: center;
      padding: 30px;
      background-color: #f9f9f9;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      font-family: Arial, sans-serif;
    }

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
      font-size: 16px;
      color: #666;
      margin-top: 5px;
    }

    .stats-cards {
      display: flex;
      justify-content: space-around;
      margin-top: 20px;
    }

    .card {
      background-color: #ffffff;
      padding: 20px;
      width: 30%;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
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
      color: #666;
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
        <!-- This is for Drop Resume -->
        <li class="" id="drop-resume-btn">
          <a href="javascript:void(0);">
            <i class="fas fa-cloud-upload-alt"></i>
            <span class="span">Drop Resume</span>
          </a>
        </li>


        <!-- This is for My Resume -->
        <li class="" id="see-resume-btn">
          <a href="javascript:void(0);"> <!-- Link to the page where resume will be viewed -->
            <i class="fas fa-file-pdf"></i> <!-- PDF icon for viewing resume -->
            <span class="span">My Resume</span>
          </a>
        </li>


        <!-- This is for Bookmarks -->
        <li class="" id="bookmarks-btn">
          <a href="javascript:void(0);">
            <i class="fas fa-bookmark"></i>
            <!-- Bookmark icon -->
            <span class="span">Bookmarks</span>
          </a>
        </li>

        <!-- This is for Apply List -->
        <li class="" id="apply-list-btn">
          <a href="javascript:void(0);"> <!-- Assuming "apply_list.php" is the page to see applied jobs -->
            <i class="fas fa-paper-plane"></i>
            <!-- Paper plane icon for applications -->
            <span class="span">Apply List</span>
          </a>
        </li>
        <!-- This is for Interview Call List -->
        <li class="" id="interview-call-btn">
          <a href="javascript:void(0);">
            <i class="fas fa-video"></i>
            <span class="span">Interview Call</span>
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
            <!-- Bookmarks Card -->
            <div class="card">
              <div class="icon">
                <i class="fas fa-bookmark"></i> <!-- Bookmark Icon -->
              </div>
              <h3>Bookmarks</h3>
              <p><span><?php echo $bookmarks_count; ?></span> Saved</p>
            </div>

            <!-- Applications Card -->
            <div class="card">
              <div class="icon">
                <i class="fas fa-paper-plane"></i> <!-- Applications Icon -->
              </div>
              <h3>Applications</h3>
              <p><span><?php echo $applications_count; ?></span> Submitted</p>
            </div>

            <!-- Interviews Card -->
            <div class="card">
              <div class="icon">
                <i class="fas fa-calendar-alt"></i> <!-- Calendar Icon -->
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
        loadContent('./profile.php'); // Load profile page
      });

      // When Drop resume button is clicked
      $('#drop-resume-btn').click(function() {
        loadContent('./drop-resume.php'); // Load company page
      });

      // When see-resume-btn button is clicked
      $('#see-resume-btn').click(function() {
        loadContent('./view_resume.php'); // Load create post page
      });

      // When bookmarks-btn button is clicked
      $('#bookmarks-btn').click(function() {
        loadContent('./show_bookmark.php'); // Load see created posts page
      });
      // When apply-list-btn button is clicked
      $('#apply-list-btn').click(function() {
        loadContent('./show_applylist.php'); // Load see created posts page
      });
      // When interview-call-btn button is clicked
      $('#interview-call-btn').click(function() {
        loadContent('./interview_call.php'); // Load see created posts page
      });
      // Function to load content dynamically into the content area
      function loadContent(page) {
        $.ajax({
          url: page, // Page to load dynamically
          type: 'GET',
          success: function(response) {
            $('#content-area').html(response); // Replace the content in #content-area div
          },
          error: function() {
            $('#content-area').html('<p>Error loading content.</p>'); // Error message in case of failure
          }
        });
      }
    });
  </script>
</body>

</html>
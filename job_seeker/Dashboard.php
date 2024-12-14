<?php
session_start();
include "../DB_Connection/DB_connection.php";

if (isset($_SESSION['js_id'])) {
  $js_id = $_SESSION['js_id'];

  $sql = "SELECT fname, job_seeker_img FROM job_seeker WHERE js_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $js_id); // "i" for integer
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if the job_seeker exists
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $fname = $row['fname'];
    $job_seeker_img = $row['job_seeker_img'];
  } else {
    $fname = "Guest";
  }
  $stmt->close();
} else {
  header("Location: login.php");
  exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TechJobHub</title>
  <link rel="stylesheet" href="./Dashboard.css" />
  <link rel="stylesheet" href="./Profile_name.css">
  <link rel="icon" type="image/png" href="../images/logo.png">

  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    rel="stylesheet" />
  <style>
    /* Center the button */
    .button-container {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .recommendation-button {
      background-color: #007BFF;
      /* Blue background */
      color: white;
      font-size: 18px;
      font-weight: bold;
      padding: 15px 30px;
      /* Padding for a larger button */
      border: none;
      border-radius: 50px;
      /* Rounded corners */
      cursor: pointer;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      /* Smooth transition for hover effects */
    }

    /* Hover effect */
    .recommendation-button:hover {
      background-color: #0056b3;
      /* Darker blue when hovered */
      transform: translateY(-4px);
      /* Slightly lift the button */
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
      /* Deeper shadow */
    }

    /* Focus effect */
    .recommendation-button:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5);
      /* Focus ring */
    }

    .profile-img {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 10px;
    }
  </style>
</head>

<body>
  <header>
    <nav>
      <div class="logo">
        <img src="../images/logo.png" alt="TechJobHub Logo" />
        <h1>TechJobHub</h1>
      </div>
      <div class="nav-links">
        <a href="./Dashboard.php">Home</a>
        <a href="../about_us.php">About Us</a>
        <a href="../contact.php">Contact</a>
      </div>
      <div class="nav-icons">
        <a href="#" title="Search" class="icon search-icon" id="search-icon">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="white">
            <path
              d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zM9.5 14C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
          </svg>
        </a>

        <!-- Search Bar -->
        <div class="search-bar-container" id="search-bar-container">
          <input
            type="text"
            class="search-bar"
            id="search-bar"
            placeholder="Search..." />
          <button class="close-btn" id="close-btn">&times;</button>
        </div>


        <a href="#" title="Profile">
          <span class="profile-name"><?php echo htmlspecialchars($fname); ?></span>
        </a>



        <!-- Profile Section -->
        <a href="#" title="Profile">
          <?php if ($job_seeker_img): ?>
            <img src="./<?php echo htmlspecialchars($job_seeker_img); ?>" alt="Profile Image" class="profile-img">
          <?php else: ?>
            <a href="#" title="Profile" class="icon profile-icon" aria-label="Profile">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
              </svg>
            </a>
          <?php endif; ?>
        </a>
        <div class="nav-links">
          <a href="../logout.php">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </div>

        <a href="./Menu.php" title="Menu" class="icon menu-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
            <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z" />
          </svg>
        </a>


      </div>
    </nav>
  </header>

  <main>
    <section class="hero">
      <h2>Search, Apply &amp; Get Your Dream Job</h2>
      <p>
        Explore opportunities, take action, and secure the career you've
        always wanted.
      </p>
    </section>
    <div class="button-container">

      <button class="recommendation-button" onclick="window.location.href='Recommendation.php';">
        Get Recommendation
      </button>
    </div>
    <section class="job-categories">
      <form action="search_post.php" method="GET" class="categories-form">
        <div class="categories-container">
          <div class="category">
            <button type="submit" name="category" value="Graphic Designer" class="category-btn">
              <i class="fas fa-paint-brush"></i>
              <span>Graphic Designer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="UI Designer" class="category-btn">
              <i class="fas fa-laptop-code"></i>
              <span>UI Designer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Motion Graphics Designer" class="category-btn">
              <i class="fas fa-video"></i>
              <span>Motion Graphics Designer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="3D Animator" class="category-btn">
              <i class="fas fa-cogs"></i>
              <span>3D Animator</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Product Designer" class="category-btn">
              <i class="fas fa-box"></i>
              <span>Product Designer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Interaction Designer" class="category-btn">
              <i class="fas fa-users"></i>
              <span>Interaction Designer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="UX Research" class="category-btn">
              <i class="fas fa-search"></i>
              <span>UX Research</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Back-end Developer" class="category-btn">
              <i class="fas fa-server"></i>
              <span>Back-end Developer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Full Stack Developer" class="category-btn">
              <i class="fas fa-code"></i>
              <span>Full Stack Developer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Embedded Systems Developer" class="category-btn">
              <i class="fas fa-microchip"></i>
              <span>Embedded Systems Developer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Game Developer (2D/3D)" class="category-btn">
              <i class="fas fa-gamepad"></i>
              <span>Game Developer (2D/3D)</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Mobile Application Developer" class="category-btn">
              <i class="fas fa-mobile-alt"></i>
              <span>Mobile Application Developer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="AR/VR Developer" class="category-btn">
              <i class="fas fa-vr-cardboard"></i>
              <span>AR/VR Developer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Firmware Developer" class="category-btn">
              <i class="fas fa-plug"></i>
              <span>Firmware Developer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="DevOps Engineer" class="category-btn">
              <i class="fas fa-cogs"></i>
              <span>DevOps Engineer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Site Reliability Engineer (SRE)" class="category-btn">
              <i class="fas fa-cloud"></i>
              <span>Site Reliability Engineer (SRE)</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Data Scientist" class="category-btn">
              <i class="fas fa-database"></i>
              <span>Data Scientist</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Junior NLP Engineer" class="category-btn">
              <i class="fas fa-brain"></i>
              <span>Junior NLP Engineer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="AI/ML Engineer" class="category-btn">
              <i class="fas fa-robot"></i>
              <span>AI/ML Engineer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Computer Vision Engineer" class="category-btn">
              <i class="fas fa-eye"></i>
              <span>Computer Vision Engineer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Generative AI Specialist" class="category-btn">
              <i class="fas fa-rocket"></i>
              <span>Generative AI Specialist</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Data Engineer" class="category-btn">
              <i class="fas fa-database"></i>
              <span>Data Engineer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="AI Ethics Specialist" class="category-btn">
              <i class="fas fa-balance-scale"></i>
              <span>AI Ethics Specialist</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Big Data Analyst" class="category-btn">
              <i class="fas fa-chart-bar"></i>
              <span>Big Data Analyst</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Robotics Engineer" class="category-btn">
              <i class="fas fa-robot"></i>
              <span>Robotics Engineer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="IoT Solutions Architect" class="category-btn">
              <i class="fas fa-network-wired"></i>
              <span>IoT Solutions Architect</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Edge AI Developer" class="category-btn">
              <i class="fas fa-microchip"></i>
              <span>Edge AI Developer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Control Systems Engineer" class="category-btn">
              <i class="fas fa-cogs"></i>
              <span>Control Systems Engineer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Autonomous Systems Engineer" class="category-btn">
              <i class="fas fa-car"></i>
              <span>Autonomous Systems Engineer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Network Engineer" class="category-btn">
              <i class="fas fa-network-wired"></i>
              <span>Network Engineer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Cloud Engineer" class="category-btn">
              <i class="fas fa-cloud"></i>
              <span>Cloud Engineer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Systems Administrator" class="category-btn">
              <i class="fas fa-cogs"></i>
              <span>Systems Administrator</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Cloud Solutions Architect" class="category-btn">
              <i class="fas fa-cloud"></i>
              <span>Cloud Solutions Architect</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Infrastructure Engineer" class="category-btn">
              <i class="fas fa-cogs"></i>
              <span>Infrastructure Engineer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Wireless Network Specialist" class="category-btn">
              <i class="fas fa-network-wired"></i>
              <span>Wireless Network Specialist</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Quality Assurance Tester" class="category-btn">
              <i class="fas fa-check-circle"></i>
              <span>Quality Assurance Tester</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Test Automation Engineer" class="category-btn">
              <i class="fas fa-robot"></i>
              <span>Test Automation Engineer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Penetration Tester (Ethical Hacker)" class="category-btn">
              <i class="fas fa-shield-alt"></i>
              <span>Penetration Tester (Ethical Hacker)</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Load and Performance Tester" class="category-btn">
              <i class="fas fa-tachometer-alt"></i>
              <span>Load and Performance Tester</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Front-end Developer" class="category-btn">
              <i class="fas fa-code"></i>
              <span>Front-end Developer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Progressive Web App (PWA) Developer" class="category-btn">
              <i class="fas fa-mobile-alt"></i>
              <span>Progressive Web App (PWA) Developer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="API Developer" class="category-btn">
              <i class="fas fa-plug"></i>
              <span>API Developer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Low-Code/No-Code Developer" class="category-btn">
              <i class="fas fa-code-branch"></i>
              <span>Low-Code/No-Code Developer</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Scrum Master" class="category-btn">
              <i class="fas fa-users-cog"></i>
              <span>Scrum Master</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="Technical Program Manager" class="category-btn">
              <i class="fas fa-project-diagram"></i>
              <span>Technical Program Manager</span>
            </button>
          </div>
          <div class="category">
            <button type="submit" name="category" value="IT Business Analyst" class="category-btn">
              <i class="fas fa-briefcase"></i>
              <span>IT Business Analyst</span>
            </button>
          </div>
        </div>
      </form>

    </section>
  </main>
  <script src="../js/Dashboard.js"></script>
</body>

</html>
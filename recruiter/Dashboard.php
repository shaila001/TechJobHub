<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TechJobHub</title>
  <link rel="icon" type="image/png" href="./images/logo.png">
</head>
<body>
  <?php
  include"./header.php";
  ?>
   <main>
    <section class="hero">
      <h2>Search Skilled Employee for Specific Fields</h2>
    </section>
    <section class="job-categories">
    <form action="search_employee.php" method="GET" class="categories-form">
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
  <script src="./Dashboard.js"></script>
</body>

</html>
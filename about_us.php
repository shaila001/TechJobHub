<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/About.css">
</head>
<body>
    <!-- Back Button -->
    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="back-btn"><i class="fas fa-arrow-left"></i> Back</a>
  <!-- About Us Section -->
  <section class="about-us">
    <div class="container">
        <div class="section-header">
            <h2>We Care About Your Life For A Better Future</h2>
            <p>Start taking time for your job search and request informational interviews with professionals in the fields you're interested in.</p>
        </div>
        <div class="about-content">
            <div class="about-text">
                <h3>What We Believe</h3>
                <p>Every single job in our database offers flexibility to match your lifestyle and career goals.</p>
                <h3>What We Offer</h3>
                <p>We provide a platform where finding your dream job is made simple, efficient, and tailored to your needs.</p>
            </div>
        </div>
    </div>
  </section>

  <!-- Services Section -->
  <section class="services">
    <div class="container">
        <h2>Our Best Services For You</h2>
        <p>Know your real worth and find the job that qualifies your life.</p>
        <div class="service-cards">
            <div class="card">
                <img src="interview.jpg" alt="Online Interview">
                <h3>Online Interview</h3>
                <p>We guide you through the process with clear steps to success.</p>
            </div>
            <div class="card">
                <img src="upload_resume.jpg" alt="CV Search">
                <h3>Upload_resume</h3>
                <p>Your Resume is matched with the best job opportunities.</p>
            </div>
            <div class="card">
                <img src="display_jobs.png" alt="Display Jobs">
                <h3>Display Jobs</h3>
                <p>Browse through job listings that match your skills and preferences.</p>
            </div>
        </div>
    </div>
  </section>

  <!-- Working Process Section -->
  <section class="working-process">
    <div class="container">
        <h2>Our Working Process</h2>
        <p>Find the perfect job step-by-step, designed for your success.</p>
        <div class="process-steps">
            <div class="step">
                <h3>01</h3>
                <h4>Create Account</h4>
                <p>Create an account to start exploring open job positions.</p>
            </div>
            <div class="step">
                <h3>02</h3>
                <h4>CV / Resume Upload</h4>
                <p>Upload your CV and get matched with relevant jobs.</p>
            </div>
            <div class="step">
                <h3>03</h3>
                <h4>Find Your Job</h4>
                <p>Explore positions that match your skills and preferences.</p>
            </div>
            <div class="step">
                <h3>04</h3>
                <h4>Apply</h4>
                <p>Apply directly for jobs that interest you.</p>
            </div>
        </div>
    </div>
  </section>
</body>
</html>

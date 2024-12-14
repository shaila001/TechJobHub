<?php
session_start();
include "./DB_Connection/DB_connection.php";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the email and password from the form
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Prevent SQL injection
  $email = $conn->real_escape_string($email);

  // Query to check if the email exists in either recruiter or job_seeker
  $sql_recruiter = "SELECT * FROM recruiter WHERE email = '$email'";
  $sql_job_seeker = "SELECT * FROM job_seeker WHERE email = '$email'";

  $result_recruiter = $conn->query($sql_recruiter);
  $result_job_seeker = $conn->query($sql_job_seeker);

  // Check if email is found in the recruiter table
  if ($result_recruiter->num_rows == 1) {
    $row = $result_recruiter->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      // Password is correct, store recruiter info in session
      $_SESSION['email'] = $email;
      $_SESSION['r_id'] = $row['r_id']; // Store recruiter id in session

      // Redirect to Recruiter Dashboard
      header("Location: ./recruiter/Dashboard.php?r_id=" . $row['r_id']);
      exit(); // Don't forget to stop further script execution
    } else {
      // Incorrect password, pass error message to JS
      echo "<script>alert('Incorrect password. Please try again.');</script>";
    }
  }
  // Check if email is found in the job_seeker table
  elseif ($result_job_seeker->num_rows == 1) {
    $row = $result_job_seeker->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      // Password is correct, store job seeker info in session
      $_SESSION['email'] = $email;
      $_SESSION['js_id'] = $row['js_id']; // Store job seeker id in session

      // Redirect to Job Seeker Dashboard
      header("Location: ./job_seeker/Dashboard.php?js_id=" . $row['js_id']);
      exit(); // Don't forget to stop further script execution
    } else {
      // Incorrect password, pass error message to JS
      echo "<script>alert('Incorrect password. Please try again.');</script>";
    }
  } else {
    // Email not found in both recruiter and job_seeker tables, pass error message to JS
    echo "<script>alert('Email not found. Please try again.');</script>";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TechJobHub</title>
  <link rel="stylesheet" href="./css/Log.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="icon" type="image/png" href="./images/logo.png">

  <style>


  </style>
</head>

<body>
  <div class="overlay">
    <div class="header">
      <img src="./images/logo.png" alt="TechJobHub Logo" class="logo" />
      <h1 class="title">TechJobHub</h1>
    </div>
    <div class="container">
      <div class="sign-in-form">
        <div class="form-header">
          <h3>Sign In &nbsp</h3>
          <p>Don't have an account? <a href="./Signup.php">Sign Up</a></p>
        </div>
        <form class="form" method="post">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required />
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required />
          <button type="submit" class="sign-in-btn">Sign In</button>
        </form>
        <a href="Forget_pass" class="forgot-password">Forgot Password?</a>
      </div>
    </div>
  </div>
  <script src="./js/Login.js"></script>
</body>

</html>
<?php
session_start();
// Include database connection
include('./DB_Connection/DB_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists in the database
    $check_email_query = $conn->prepare("SELECT email FROM recruiter WHERE email = ? UNION SELECT email FROM job_seeker WHERE email = ?");
    $check_email_query->bind_param("ss", $email, $email);
    $check_email_query->execute();
    $check_email_query->store_result();

    if ($check_email_query->num_rows > 0) {
        // Email already exists
        echo "<script>alert('This email is already registered. Please use another email.');</script>";
    } else {
        // Prepare the query based on role
        if ($role == 'Recruiter') {
            // Prepare and execute query to insert into the recruiter table
            $query = $conn->prepare("INSERT INTO recruiter (fname, lname, email, password) VALUES (?, ?, ?, ?)");
            $query->bind_param("ssss", $fname, $lname, $email, $hashed_password);
        } elseif ($role == 'Job Seeker') {
            // Prepare and execute query to insert into the job_seeker table
            $query = $conn->prepare("INSERT INTO job_seeker (fname, lname, email, password) VALUES (?, ?, ?, ?)");
            $query->bind_param("ssss", $fname, $lname, $email, $hashed_password);
        } else {
            echo "<script>alert('Invalid role selected!');</script>";
            exit();
        }
        
        // Execute the query
        if ($query->execute()) {
            // If recruiter, redirect to company details page with recruiter ID
            if ($role == 'Recruiter') {
                // Get the recruiter ID
                $r_id = $conn->insert_id; // Get the last inserted recruiter ID
                // Redirect to company details page for recruiters
                echo "<script>alert('Registration successful! You can now log in.'); window.location.href='./recruiter/company_details.php?r_id=" . $r_id . "';</script>";
            } else {
                // Redirect to login page for job seekers
                echo "<script>alert('Registration successful! You can now log in.'); window.location.href='./Login.php';</script>";
            }
        } else {
            // Handle any errors
            echo "<script>alert('Error: " . $query->error . "');</script>";
        }
        
        // Close the query
        $query->close();
    }

    // Close the database connection
    $check_email_query->close();
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TechJobHub</title>
  <link rel="stylesheet" href="./css/sig.css">
  <link rel="icon" type="image/png" href="./images/logo.png">
  <style>
  </style>
</head>
<body>
  <div class="overlay">
    <div class="header">
      <img src="./images/logo.png" alt="TechJobHub Logo" class="logo">
      <h1 class="title">TechJobHub</h1>
    </div>
    <div class="container">
      <div class="content">
        
      </div>
      <div class="sign-up-form">
        <div class="form-header">
          <h3>Sign Up</h3>
          <a href="Login.php">Sign In</a>
        </div>
        <div class="messages">
          <!-- Show any messages here -->
        </div>
        <form class="form" method="post">
          <label for="fname">First Name</label>
          <input type="text" id="fname" name="fname" required>

          <label for="lname">Last Name</label>
          <input type="text" id="lname" name="lname" required>

          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>

          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>

          <label for="role">Role</label>
          <input list="role-list" name="role" id="role" required>
          <datalist id="role-list">
            <option value="Recruiter">
            <option value="Job Seeker">
          </datalist>

          <button type="submit" class="sign-up-btn">Sign Up</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Show the appropriate fields based on the selected role
    document.getElementById('role').addEventListener('input', function() {
      var role = this.value;
      // No additional fields for Job Seeker or Recruiter now, so no changes required
    });
  </script>

  <script src="./js/Signup.js"></script>
</body>
</html>

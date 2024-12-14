<?php
session_start();
include "../DB_Connection/DB_connection.php";

// Get the recruiter ID from the URL (using GET method)
if (isset($_GET['r_id'])) {
    $r_id = $_GET['r_id'];

    // Query to fetch recruiter details
    $sql = "SELECT fname FROM recruiter WHERE r_id = '$r_id'";
    $result = $conn->query($sql);

    // Fetch the recruiter's first name
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $fname = $row['fname']; // Store the first name in a variable
    } else {
        // If the recruiter ID is invalid, handle the error
        $fname = "Unknown";
        // Optionally, redirect or show an error message
        echo "Invalid recruiter ID. Please try again.";
        exit();
    }
} else {
    // If r_id is not set, handle the error
    echo "No recruiter ID provided. Please provide a valid recruiter ID.";
    exit();
}

// Form submission handling
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $company_name = $_POST['company-name'];
    $address = $_POST['address'];
    $license = $_POST['license'];
    $website = $_POST['website'];

    // Prevent SQL injection
    $company_name = $conn->real_escape_string($company_name);
    $address = $conn->real_escape_string($address);
    $license = $conn->real_escape_string($license);
    $website = $conn->real_escape_string($website);

    // Check if 'license' and 'website' are empty and handle accordingly
    $license_value = empty($license) ? "NULL" : "'$license'";
    $website_value = empty($website) ? "NULL" : "'$website'";

    // SQL query to insert the company details into the database
    $sql = "INSERT INTO company (recruiter_id, name, address, trade_license_number, website)
            VALUES ('$r_id', '$company_name', '$address', $license_value, $website_value)";

    // Execute the query and handle success or failure
    if ($conn->query($sql) === TRUE) {
        header("Location: ../Login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
  <link rel="stylesheet" href="../css/company_details.css" />
  <link rel="icon" type="image/png" href="./images/logo.png">
</head>

<body>
  <header>
    <div class="logo">
      <img src="../images/logo.png" alt="TechJobHub Logo" />
      <h1>TechJobHub</h1>
    </div>
    <nav>
      <span>Welcome, <?php echo htmlspecialchars($fname); ?>!</span>
      <a href="#">About</a>
      <a href="../Home.php">Logout</a>
    </nav>
  </header>

  <main>
    <div class="form-container">
      <form method="POST" action="">
        <div class="company-details">
          <h2>COMPANY DETAILS</h2>

          <label for="company-name">Company Name*</label>
          <input type="text" id="company-name" name="company-name" required />

          <label for="address">Company Address*</label>
          <input type="text" id="address" name="address" required />

          <label for="license">Trade License No</label>
          <input type="text" id="license" name="license" />

          <label for="website">Website URL</label>
          <input type="url" id="website" name="website" />
        </div>

        <button type="submit">Submit</button>
      </form>
    </div>
  </main>

  <!-- <script src="./js/company_details.js"></script> -->
</body>

</html>

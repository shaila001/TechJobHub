<?php
session_start();
include "../DB_Connection/DB_connection.php";

// Ensure recruiter ID is available in the session
if (isset($_SESSION['r_id'])) {
    $r_id = $_SESSION['r_id'];

    // Query to fetch company details for the given recruiter ID
    $sql = "SELECT * FROM company WHERE recruiter_id = '$r_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $company = $result->fetch_assoc();
    } else {
        $company = null;
    }
} else {
    header("Location: ../Login.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Details - TechJobHub</title>
    <link rel="stylesheet" href="./company_details.css">
    <link rel="icon" type="image/png" href="./images/logo.png">

</head>

<body>
    <main>
        <div class="company-container">
            <h2 class="company-title">Company Details</h2>

            <?php if ($company): ?>
            <div class="company-info">

                <!-- Company Name -->
                <div class="form-group">
                    <label for="company-name">Company Name</label>
                    <input type="text" id="company-name" name="company-name" value="<?= htmlspecialchars($company['name']) ?>" disabled>
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" disabled><?= htmlspecialchars($company['address']) ?></textarea>
                </div>

                <!-- Trade License No -->
                <div class="form-group">
                    <label for="license">Trade License No</label>
                    <input type="text" id="license" name="license" value="<?= htmlspecialchars($company['trade_license_number']) ?>" disabled>
                </div>

                <!-- Website -->
                <div class="form-group">
                    <label for="website">Website</label>
                    <a href="<?= htmlspecialchars($company['website']) ?>" target="_blank"><?= htmlspecialchars($company['website']) ?></a>
                </div>
            <?php else: ?>
            <p>No company details available.</p>
            <?php endif; ?>
        </div>
    </main>

  

</body>

</html>

<?php
session_start();

// Get recruiter_id from the session
$rId = isset($_SESSION['r_id']) ? $_SESSION['r_id'] : null;

if (!$rId) {
    echo "No recruiter ID provided!";
    exit;
}

// Include the database connection
include "../DB_Connection/DB_connection.php";

// Fetch recruiter data for editing
$query = "SELECT * FROM recruiter WHERE r_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $rId);
$stmt->execute();
$result = $stmt->get_result();
$recruiter = $result->fetch_assoc();

if (!$recruiter) {
    echo "Recruiter not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recruiter Profile</title>
    <link rel="stylesheet" href="./edit_profile.css">
</head>
<body>
    <div class="profile-container">
        <h2>Edit Profile</h2>
        
        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
            <!-- Profile Picture Section -->
            <div class="profile-img-wrapper">
                <div class="profile-img-container">
                    <img src="<?= htmlspecialchars($recruiter['recruiter_img'] ?? '/path/to/default-avatar.png') ?>" 
                        alt="Profile Picture" class="profile-img">
                </div>
            </div>

            <!-- First Name -->
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" id="fname" name="fname" value="<?= htmlspecialchars($recruiter['fname']) ?>" required>
            </div>

            <!-- Last Name -->
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" id="lname" name="lname" value="<?= htmlspecialchars($recruiter['lname']) ?>" required>
            </div>
            <!-- Address -->
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" required><?= htmlspecialchars($recruiter['address']) ?></textarea>
            </div>

            <!-- Profile Image -->
            <div class="form-group">
                <label for="recruiter_img">Profile Image</label>
                <input type="file" id="recruiter_img" name="recruiter_img">
            </div>

            <button type="submit" class="btn-save">Save Changes</button>
        </form>
    </div>
</body>
</html>

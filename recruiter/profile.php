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

// Prepare and execute the query to fetch recruiter data
$query = "SELECT * FROM recruiter WHERE r_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $rId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the recruiter data
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
    <title>Recruiter Profile</title>
    <link rel="stylesheet" href="profile.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is loaded -->
</head>

<body>
    <div class="profile-container">
        <!-- Profile Picture Section -->
        <div class="profile-img-wrapper">
            <div class="profile-img-container">
                <img src="<?= htmlspecialchars($recruiter['recruiter_img'] ?? '/path/to/default-avatar.png') ?>" 
                    alt="Profile Picture" class="profile-img">
            </div>
        </div>

        <table class="profile-table">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row 1: First Name -->
                <tr class="table-row">
                    <td class="label">First Name</td>
                    <td><?= htmlspecialchars($recruiter['fname']) ?></td>
                </tr>
                <!-- Row 2: Last Name -->
                <tr class="table-row">
                    <td class="label">Last Name</td>
                    <td><?= htmlspecialchars($recruiter['lname']) ?></td>
                </tr>
                <!-- Row 3: Email -->
                <tr class="table-row">
                    <td class="label">Email</td>
                    <td><?= htmlspecialchars($recruiter['email']) ?></td>
                </tr>
                <!-- Row 4: Address -->
                <tr class="table-row">
                    <td class="label">Address</td>
                    <td><?= htmlspecialchars($recruiter['address']) ?></td>
                </tr>
            </tbody>
        </table>
          <!-- Edit Profile Button -->
          <div class="edit-profile-btn">
            <button id="editProfileButton" class="btn-edit-profile">Edit Profile</button>
        </div>

    </div>

    <!-- Script for AJAX Request to Load Edit Profile Form -->
    <script>
        $(document).ready(function() {
            $('#editProfileButton').click(function() {
                $.ajax({
                    url: 'edit_profile.php',  // URL to the file that contains the edit form
                    type: 'GET',
                    success: function(response) {
                        $('#content-area').html(response); 
                    },
                    error: function() {
                        alert('Error loading the edit profile form');
                    }
                });
            });
        });
    </script>
    </div>
</body>

</html>

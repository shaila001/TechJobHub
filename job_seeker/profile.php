<?php
session_start();

// Get job_seeker ID from the session
$jsId = isset($_SESSION['js_id']) ? $_SESSION['js_id'] : null;

if (!$jsId) {
    echo "No job_seeker ID provided!";
    exit;
}

// Include the database connection
include "../DB_Connection/DB_connection.php";

// Prepare and execute the query to fetch job_seeker data
$query = "SELECT * FROM job_seeker WHERE js_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $jsId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the job_seeker data
$job_seeker = $result->fetch_assoc();

if (!$job_seeker) {
    echo "Job seeker not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($job_seeker['fname'] . ' ' . $job_seeker['lname']) ?> - Profile</title>
    <link rel="stylesheet" href="profile.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            width: 80%;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .profile-img-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .profile-img-container {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
        }

        .profile-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .profile-table th,
        .profile-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .profile-table th {
            background-color: #f5f5f5;
        }

        .profile-table td {
            background-color: #fafafa;
        }

        .profile-table .label {
            font-weight: bold;
        }

        .edit-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }

        .edit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="profile-container">
        <!-- Profile Picture Section -->
        <div class="profile-img-wrapper">
            <div class="profile-img-container">
                <img src="<?= htmlspecialchars($job_seeker['job_seeker_img'] ?? './Profile_img/default-avatar.jpg') ?>" alt="Profile Picture">
            </div>
        </div>

        <h2><?= htmlspecialchars($job_seeker['fname'] . ' ' . $job_seeker['lname']) ?></h2>

        <table class="profile-table">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row 1: Email -->
                <tr class="table-row">
                    <td class="label">Email</td>
                    <td><?= htmlspecialchars($job_seeker['email']) ?></td>
                </tr>
                <!-- Row 2: Mobile Number -->
                <tr class="table-row">
                    <td class="label">Mobile Number</td>
                    <td><?= htmlspecialchars($job_seeker['mobile_number']) ?></td>
                </tr>
                <!-- Row 3: Address -->
                <tr class="table-row">
                    <td class="label">Address</td>
                    <td><?= htmlspecialchars($job_seeker['address']) ?></td>
                </tr>
                <!-- Row 4: Experience -->
                <tr class="table-row">
                    <td class="label">Fields of Experience</td>
                    <td>
                        <?= htmlspecialchars($job_seeker['experience_1']) ?><br>
                        <?= htmlspecialchars($job_seeker['experience_2']) ?><br>
                        <?= htmlspecialchars($job_seeker['experience_3']) ?>
                    </td>
                </tr>
                <!-- Row 5: Interest -->
                <tr class="table-row">
                    <td class="label">Fields of Interest</td>
                    <td>
                        <?= htmlspecialchars($job_seeker['interest_1']) ?><br>
                        <?= htmlspecialchars($job_seeker['interest_2']) ?><br>
                        <?= htmlspecialchars($job_seeker['interest_3']) ?>
                    </td>
                </tr>

            </tbody>
        </table>
        <!-- <a href="edit_profile.php" class="edit-btn" id="editProfileButton">Edit Profile</a> -->
        <button class="edit-btn" id="editProfileButton">Edit Profile</button>

    </div>
    <!-- Script for AJAX Request to Load Edit Profile Form -->
    <script>
        $(document).ready(function() {
            $('#editProfileButton').click(function() {
                $.ajax({
                    url: 'edit_profile.php', // URL to the file that contains the edit form
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
</body>

</html>
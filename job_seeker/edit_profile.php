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

// Fetch job_seeker data for editing
$query = "SELECT * FROM job_seeker WHERE js_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $jsId);
$stmt->execute();
$result = $stmt->get_result();
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
    <title>Edit Job Seeker Profile</title>
    <link rel="stylesheet" href="./edit_profile.css">
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

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .form-group input[type="text"],
        .form-group input[type="file"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-group textarea {
            height: 80px;
        }

        .add-more-btn {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            cursor: pointer;
            font-weight: bold;
        }

        .add-more-btn:hover {
            text-decoration: underline;
        }

        .two-column {
            display: flex;
            gap: 20px;
        }

        .two-column .form-group {
            flex: 1;
        }

        /* Centering the form group containing the button */
        .form-group:last-child {
            display: flex;
            justify-content: center;
            /* Centers the button horizontally */
            margin-top: 20px;
            /* Adds some space above the button */
        }

        /* Button styling remains unchanged */
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 24px;
            text-transform: uppercase;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Hover effect remains unchanged */
        button:hover {
            background-color: #45a049;
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .suggestion-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
            position: absolute;
            background: #fff;
            border: 1px solid #ddd;
            width: calc(100% - 20px);
            z-index: 100;
            max-height: 150px;
            overflow-y: auto;
        }

        .suggestion-list li {
            padding: 8px;
            cursor: pointer;
        }

        .suggestion-list li:hover {
            background-color: #f0f0f0;
        }

        /* Back Button Styling */
        .back-btn {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            font-size: 18px;
            color: #007bff;
            margin-bottom: 20px;
            padding: 5px 15px;
            background-color: #f0f8ff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #d6e9f7;
        }

        .back-btn i {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <h2>Edit Profile</h2>

        <form action="update_profile.php" method="POST" enctype="multipart/form-data">

            <!-- Profile Picture Section -->
            <div class="profile-img-wrapper">
                <div class="profile-img-container">
                    <img src="<?= htmlspecialchars($job_seeker['job_seeker_img'] ?? './Profile_img/default-avatar.jpg') ?>"
                        alt="Profile Picture" class="profile-img" style="max-width: 150px; height: auto;">
                </div>
            </div>
            <!-- Profile Image Upload -->
            <div class="form-group">
                <label for="job_seeker_img">Change Profile Picture</label>
                <input type="file" id="job_seeker_img" name="job_seeker_img">
            </div>

            <!-- First Name and Last Name (Two Column) -->
            <div class="two-column">
                <div class="form-group">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" value="<?= htmlspecialchars($job_seeker['fname']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" value="<?= htmlspecialchars($job_seeker['lname']) ?>" required>
                </div>
            </div>

            <!-- Mobile Number (One Column) -->
            <div class="form-group">
                <label for="mobile_number">Mobile Number</label>
                <input type="text" id="mobile_number" name="mobile_number" value="<?= htmlspecialchars($job_seeker['mobile_number']) ?>" required>
            </div>

            <!-- Address (One Column) -->
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" required><?= htmlspecialchars($job_seeker['address']) ?></textarea>
            </div>

            <!-- Experience (Two Column) -->
            <div class="two-column">
                <div class="form-group">
                    <label for="experience_1">Field of Experience </label>
                    <input type="text" id="experience_1" name="experience_1" value="<?= htmlspecialchars($job_seeker['experience_1']) ?>">
                </div>
                <div class="form-group" id="experience_2_div" style="display: none;">
                    <label for="experience_2">Experience 2</label>
                    <input type="text" id="experience_2" name="experience_2" value="<?= htmlspecialchars($job_seeker['experience_2']) ?>">
                </div>
                <div class="form-group" id="experience_3_div" style="display: none;">
                    <label for="experience_3">Experience 3</label>
                    <input type="text" id="experience_3" name="experience_3" value="<?= htmlspecialchars($job_seeker['experience_3']) ?>">
                </div>
            </div>

            <!-- Field of Interest (Two Column) -->
            <div class="two-column">
                <div class="form-group">
                    <label for="interest_1">Field of Interest</label>
                    <input type="text" id="interest_1" name="interest_1" value="<?= htmlspecialchars($job_seeker['interest_1']) ?>">
                </div>
                <div class="form-group" id="interest_2_div" style="display: none;">
                    <label for="interest_2">Interest 2</label>
                    <input type="text" id="interest_2" name="interest_2" value="<?= htmlspecialchars($job_seeker['interest_2']) ?>">
                </div>
                <div class="form-group" id="interest_3_div" style="display: none;">
                    <label for="interest_3">Interest 3</label>
                    <input type="text" id="interest_3" name="interest_3" value="<?= htmlspecialchars($job_seeker['interest_3']) ?>">
                </div>
            </div>

            <!-- Add More Buttons -->
            <div class="form-group">
                <span class="add-more-btn" id="add-more-experience">Add More Experience</span>
                <span class="add-more-btn" id="add-more-interest">Add More Interest</span>
            </div>



            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit">Save Changes</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('add-more-experience').addEventListener('click', function() {
            document.getElementById('experience_2_div').style.display = 'block';
            document.getElementById('experience_3_div').style.display = 'block';
        });

        document.getElementById('add-more-interest').addEventListener('click', function() {
            document.getElementById('interest_2_div').style.display = 'block';
            document.getElementById('interest_3_div').style.display = 'block';
        });
    </script>
   <script src="./load_suggestion.js"></script>
</body>

</html>
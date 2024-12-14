<?php
session_start();
include('../DB_Connection/DB_connection.php');

// Get job seeker ID from session
$js_id = $_SESSION['js_id'];

// Get post ID from the URL
$post_id = $_GET['post_id'];

// Check if the form is submitted and password is provided
if (isset($_POST['password']) && !empty($_POST['password'])) {
    $password = $_POST['password'];

    // Fetch the stored password hash from the job_seeker table
    $sql = "SELECT password FROM job_seeker WHERE js_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $js_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the entered password against the hashed password in the database
        if (password_verify($password, $hashed_password)) {
            // Check if the job seeker has already applied for this job
            $check_sql = "SELECT * FROM application WHERE job_seeker_id = ? AND job_post_id = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("ii", $js_id, $post_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                // If the job seeker has already applied for this job
                echo "<script>alert('You have already applied for this job.');</script>";
            } else {
                // Insert the application if not already applied
                $sql_insert = "INSERT INTO application (job_seeker_id, job_post_id) VALUES (?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("ii", $js_id, $post_id);
                $stmt_insert->execute();

                if ($stmt_insert->affected_rows > 0) {
                    // Show success message and redirect to the parent page (referrer)
                    echo "<script>alert('Application successfully submitted!');</script>";
                } else {
                    // Error while inserting application
                    echo "<script>alert('Error applying for the job. Please try again later.');</script>";
                }
            }
        } else {
            // If password is incorrect
            echo "<script>alert('Incorrect password. Please try again.');</script>";
        }
    } else {
        // If user not found
        echo "<script>alert('User not found. Please log in again.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="./images/logo.png">

    <style>
        /* Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            padding: 30px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }

        /* Main Container */
        .container {
            width: 100%;
            max-width: 600px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            transform: translateY(-10%);
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Animation for fade-in effect */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-10%);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header Style */
        h2 {
            font-size: 32px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 30px;
        }

        .form-group label {
            font-size: 16px;
            font-weight: 500;
            color: #555;
            display: block;
            text-align: left;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            border: 2px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            color: #555;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #007bff;
            background-color: #fff;
        }

        /* Button Style */
        .btn {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn:focus {
            outline: none;
        }

        /* Custom Link Style */
        .forgot-password {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            display: block;
            margin-top: 10px;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Back Button Styling */
        .back-btn {
            position: absolute;
            top: 30px;
            left: 30px;
            font-size: 18px;
            color: #007bff;
            background: none;
            border: none;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .back-btn:hover {
            color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 25px;
            }

            h2 {
                font-size: 28px;
            }

            .form-group input {
                font-size: 16px;
                padding: 12px;
            }

            .btn {
                font-size: 16px;
                padding: 12px;
            }
        }
    </style>
</head>
<body>

    <!-- Back Button -->
    <button class="back-btn" onclick="window.history.back();"><i class="fas fa-arrow-left"></i> Back</button>

    <div class="container">
        <h2>Apply for the Job</h2>

        <!-- Password Prompt Form -->
        <form action="apply_job.php?post_id=<?php echo $post_id; ?>" method="POST">
            <div class="form-group">
                <label for="password">Enter Your Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
            </div>

            <button type="submit" class="btn">Submit Application</button>
            <a href="#" class="forgot-password">Forgot your password?</a>
        </form>
    </div>

</body>
</html>

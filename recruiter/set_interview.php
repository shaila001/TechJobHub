<?php
session_start();

// Include the database connection
include "../DB_Connection/DB_connection.php";

// Check if interview_id is provided
if (!isset($_GET['interview_id']) || empty($_GET['interview_id'])) {
    die("Interview ID is required.");
}

$interview_id = $_GET['interview_id'];

// Fetch the current interview details
$sql = "SELECT interview_id, status, meeting_url, date FROM interview WHERE interview_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmt->bind_param('i', $interview_id);
$stmt->execute();
$result = $stmt->get_result();
$interview = $result->fetch_assoc();

if (!$interview) {
    die("Interview not found.");
}

// Close the result set and statement
$stmt->close();
?>

<!-- HTML to display the form and current interview details -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Interview</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .interview-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
        }

        input,
        select {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .cancel-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .cancel-btn:hover {
            background-color: #e53935;
        }
    </style>
</head>

<body>

    <div class="interview-container">
        <h2>Modify Interview Details</h2>
        <form method="POST" action="update_interview_details.php">
            <input type="hidden" name="interview_id" value="<?php echo htmlspecialchars($interview['interview_id']); ?>">
            <label for="status">Interview Status</label>
            <select name="status" id="status" required>
                <option value="pending" <?php echo ($interview['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="complete" <?php echo ($interview['status'] == 'complete') ? 'selected' : ''; ?>>Complete</option>
                <option value="canceled" <?php echo ($interview['status'] == 'canceled') ? 'selected' : ''; ?>>Canceled</option>
            </select>

            <label for="meeting_url">Meeting URL</label>
            <input type="text" name="meeting_url" id="meeting_url" value="<?php echo htmlspecialchars($interview['meeting_url']); ?>" placeholder="Enter meeting URL">

            <label for="date">Interview Date</label>
            <input type="datetime-local" name="date" id="date" value="<?php echo date('Y-m-d\TH:i', strtotime($interview['date'])); ?>" required>

            <div class="buttons">
                <button type="submit" class="submit-btn">Save Changes</button>
                <a href="Menu.php" class="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>

</body>

</html>
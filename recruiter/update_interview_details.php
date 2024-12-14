<?php
session_start();

// Include the database connection
include "../DB_Connection/DB_connection.php";

// Check if the form was submitted and the required data is present
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form inputs
    $interview_id = isset($_POST['interview_id']) ? $_POST['interview_id'] : null;
    $meeting_url = isset($_POST['meeting_url']) ? $_POST['meeting_url'] : null;
    $date = isset($_POST['date']) ? $_POST['date'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;

    if (!$interview_id) {
        die("Interview ID is required.");
    }

    // Prepare the update query
    $update_sql = "UPDATE interview SET ";
    $params = [];
    $types = '';

    if ($meeting_url) {
        $update_sql .= "meeting_url = ?, ";
        $params[] = $meeting_url;
        $types .= 's'; // 's' for string
    }

    if ($date) {
        $update_sql .= "date = ?, ";
        $params[] = $date;
        $types .= 's'; // 's' for string (datetime)
    }

    if ($status) {
        $update_sql .= "status = ?, ";
        $params[] = $status;
        $types .= 's'; // 's' for string
    }

    // Remove the trailing comma and space
    $update_sql = rtrim($update_sql, ', ');

    // Add the WHERE clause to specify the interview_id
    $update_sql .= " WHERE interview_id = ?";

    // Bind the parameters for the update query
    $params[] = $interview_id; // Binding interview_id at the end
    $types .= 'i'; // 'i' for integer (interview_id)

    // Prepare the update query
    $update_stmt = $conn->prepare($update_sql);
    if ($update_stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Bind parameters to the prepared statement
    $update_stmt->bind_param($types, ...$params);

    if ($update_stmt->execute()) {
        // Success: Alert and Redirect to Menu.php
        echo "<script>
                alert('Interview details updated successfully.');
                window.location.href = '';
              </script>";
    } else {
        echo "<script>
                alert('Error updating interview details: " . $update_stmt->error . "');
                window.location.href = 'Menu.php';
              </script>";
    }

    // Close the prepared statement
    $update_stmt->close();
} else {
    header('Location: Menu.php');
    exit;
}

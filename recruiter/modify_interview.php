<?php
session_start();
include "../DB_Connection/DB_connection.php";

if (!isset($_GET['interview_id'])) {
    die("Interview ID is required.");
}

$interview_id = $_GET['interview_id'];

// Fetch current interview details
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

// If form is submitted, update the interview details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = isset($_POST['status']) ? $_POST['status'] : $interview['status'];
    $meeting_url = isset($_POST['meeting_url']) ? $_POST['meeting_url'] : $interview['meeting_url'];
    $date = isset($_POST['date']) ? $_POST['date'] : $interview['date'];

    // Prepare the update query
    $update_sql = "UPDATE interview SET status = ?, meeting_url = ?, date = ? WHERE interview_id = ?";
    $stmt_update = $conn->prepare($update_sql);
    if ($stmt_update === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt_update->bind_param('sssi', $status, $meeting_url, $date, $interview_id);
    $stmt_update->execute();

    if ($stmt_update->affected_rows > 0) {
        echo "Interview updated successfully.";
    } else {
        echo "No changes were made.";
    }
}
?>

<!-- Example HTML Form for Editing (optional) -->
<form action="modify_interview.php?interview_id=<?php echo $interview_id; ?>" method="POST">
    <label>Status:</label>
    <select name="status">
        <option value="pending" <?php echo ($interview['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
        <option value="complete" <?php echo ($interview['status'] == 'complete') ? 'selected' : ''; ?>>Complete</option>
        <option value="canceled" <?php echo ($interview['status'] == 'canceled') ? 'selected' : ''; ?>>Canceled</option>
    </select><br>

    <label>Meeting URL:</label>
    <input type="text" name="meeting_url" value="<?php echo htmlspecialchars($interview['meeting_url']); ?>"><br>

    <label>Date:</label>
    <input type="datetime-local" name="date" value="<?php echo date('Y-m-d\TH:i', strtotime($interview['date'])); ?>"><br>

    <button type="submit">Update</button>
</form>

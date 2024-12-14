<?php
session_start();

include "../DB_Connection/DB_connection.php";

if (!isset($_POST['r_id']) || !isset($_POST['js_id']) || !isset($_POST['post_id'])) {
    die('Missing parameters!');
}

$r_id = $_POST['r_id'];
$js_id = $_POST['js_id'];
$post_id = $_POST['post_id'];

$sql = "SELECT * FROM interview WHERE r_id = ? AND js_id = ? AND post_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('iii', $r_id, $js_id, $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Interview already scheduled.";
} else {
    // Insert new interview entry
    $sql = "INSERT INTO interview (r_id, js_id, post_id, status, meeting_url) VALUES (?, ?, ?, 'pending', '')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii', $r_id, $js_id, $post_id);
    
    if ($stmt->execute()) {
        echo "Interview scheduled successfully!";
    } else {
        echo "Error scheduling interview: " . $conn->error;
    }
}

$stmt->close();
?>

<?php
session_start();

include "../DB_Connection/DB_connection.php";

// Get recruiter ID from the session
$r_id = $_SESSION['r_id'];

// Fetch interviews directly for the recruiter
$sql = "SELECT i.interview_id, i.status, i.date, i.meeting_url, js.fname, js.lname, jp.title
        FROM interview i
        JOIN job_seeker js ON i.js_id = js.js_id
        JOIN job_post jp ON i.post_id = jp.post_id
        WHERE i.r_id = ? -- Only fetch interviews belonging to the current recruiter
        ORDER BY 
            CASE 
                WHEN i.status = 'pending' THEN 1
                WHEN i.status = 'complete' THEN 2
                WHEN i.status = 'canceled' THEN 3
                ELSE 4
            END";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

// Bind recruiter ID to the query
$stmt->bind_param('i', $r_id);
$stmt->execute();
$result = $stmt->get_result();
$interviews = $result->fetch_all(MYSQLI_ASSOC);

// Check if no interviews exist
if (empty($interviews)) {
    echo "<p>No interviews found.</p>";
} else {
    echo "<div class='interviews-container'>";
    echo "<table class='interview-table'>
            <thead>
                <tr>
                    <th>Job Post</th>
                    <th>Job Applicant</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Meeting URL</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>";

    // Loop through interviews
    foreach ($interviews as $interview) {
        echo "<tr>
                <td>" . htmlspecialchars($interview['title']) . "</td>
                <td>" . htmlspecialchars($interview['fname'] . ' ' . $interview['lname']) . "</td>
                <td>" . htmlspecialchars(ucfirst($interview['status'])) . "</td>
                <td>" . htmlspecialchars(date('F j, Y, g:i a', strtotime($interview['date']))) . "</td>
                <td>" . ($interview['meeting_url'] ? '<a href="' . htmlspecialchars($interview['meeting_url']) . '" target="_blank">Join Meeting</a>' : 'No URL Provided') . "</td>
                <td><button class='modify-btn' data-interview-id='" . $interview['interview_id'] . "'>Modify</button></td>
            </tr>";
    }

    echo "</tbody></table>";
    echo "</div>";
}
?>

<!-- CSS Styling -->
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .job-posts-container {
        padding: 20px;
        margin: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h3 {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .modify-btn {
        background-color: #007bff;
        color: white;
        padding: 8px 15px;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .modify-btn:hover {
        background-color: #0056b3;
    }

    .modify-btn {
        display: inline-block;
        text-align: center;
    }

    td a {
        color: #007bff;
        text-decoration: none;
    }

    td a:hover {
        text-decoration: underline;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // When the Modify button is clicked
        $(".modify-btn").click(function() {
            var interviewId = $(this).data("interview-id");

            // Send AJAX request
            $.ajax({
                url: "set_interview.php",
                method: "GET",
                data: {
                    interview_id: interviewId
                },
                success: function(response) {
                    $('#content-area').html(response);
                },
                error: function() {
                    alert("An error occurred while processing your request.");
                }
            });
        });
    });
</script>
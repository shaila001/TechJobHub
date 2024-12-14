<?php
session_start();
include "../DB_Connection/DB_connection.php";

$js_id = $_SESSION['js_id']; 

$sql = "SELECT interview_id, post_id, status, meeting_url, date
        FROM interview
        WHERE js_id = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}
$stmt->bind_param('i', $js_id); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>No interviews found.</p>";
} else {
    echo "<div class='interviews-container'>
            <table class='interviews-table'>
                <thead>
                    <tr>
                        <th>Job Post Title</th>
                        <th>Company Name</th>
                        <th>Interview Status</th>
                        <th>Meeting URL</th>
                        <th>Interview Date</th>
                    </tr>
                </thead>
                <tbody>";

    // Loop through all interviews
    while ($interview = $result->fetch_assoc()) {
        $post_id = $interview['post_id'];
        $meeting_url = $interview['meeting_url'] ? "<a href='{$interview['meeting_url']}' class='join-btn' target='_blank'>Join Meeting</a>" : "<span class='no-link'>No Meeting Link</span>";
        $interview_date = $interview['date'];
        $formatted_date = date("d M, Y h:i A", strtotime($interview_date)); // Format date as '24 Dec, 2024 9:10 PM'

        // Fetch job post title and company name
        $sql_post = "SELECT title, recruiter_id FROM job_post WHERE post_id = ?";
        $stmt_post = $conn->prepare($sql_post);
        $stmt_post->bind_param('i', $post_id);
        $stmt_post->execute();
        $result_post = $stmt_post->get_result();
        $job_post = $result_post->fetch_assoc();
        $job_title = $job_post['title'];
        $recruiter_id = $job_post['recruiter_id'];

        // Fetch company name
        $sql_company = "SELECT name FROM company WHERE recruiter_id = ?";
        $stmt_company = $conn->prepare($sql_company);
        $stmt_company->bind_param('i', $recruiter_id);
        $stmt_company->execute();
        $result_company = $stmt_company->get_result();
        $company = $result_company->fetch_assoc();
        $company_name = $company['name'];

        echo "<tr>
                <td>{$job_title}</td>
                <td>{$company_name}</td>
                <td class='" . strtolower($interview['status']) . "'>{$interview['status']}</td>
                <td>{$meeting_url}</td>
                <td>{$formatted_date}</td>
              </tr>";
    }

    echo "</tbody>
        </table>
    </div>";
}
?>



<style>
    /* General Reset and Basic Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f6f9;
        color: #333;
    }

    /* Main container for the table */
    .interviews-container {
        margin: 20px auto;
        padding: 20px;
        max-width: 1000px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    /* Table Styling */
    .interviews-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        background-color: #fff;
    }

    .interviews-table th,
    .interviews-table td {
        padding: 12px 15px;
        text-align: left;
        font-size: 14px;
        color: #555;
    }

    .interviews-table th {
        background: #4e00b1;
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
        padding: 12px 15px;
        text-align: left;
        border-bottom: 2px solid #ddd;
    }


    .interviews-table td {
        border-bottom: 1px solid #ddd;
    }

    .interviews-table tr:hover {
        background-color: #f1f1f1;
        transform: scale(1.02);
        transition: all 0.3s ease;
    }

    .interviews-table .pending {
        color: #f39c12;
    }

    .interviews-table .complete {
        color: #27ae60;
    }

    .interviews-table .canceled {
        color: #e74c3c;
    }

    /* Join Meeting Button */
    .join-btn {
        display: inline-block;
        padding: 8px 15px;
        background-color: #2ecc71;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .join-btn:hover {
        background-color: #27ae60;
    }

    /* No Link Placeholder */
    .no-link {
        color: #888;
        font-style: italic;
    }

    /* Responsive Design */
    @media screen and (max-width: 768px) {

        .interviews-table th,
        .interviews-table td {
            padding: 10px;
            font-size: 12px;
        }

        .interviews-table {
            font-size: 14px;
        }

        .interviews-container {
            margin: 10px;
            padding: 15px;
        }
    }
</style>
<?php
include"./header.php";
include('../DB_Connection/DB_connection.php');

// Get the selected category from the GET request
$category = isset($_GET['category']) ? $_GET['category'] : '';

if ($category) {
    // Prepare SQL query to search for job seekers based on experience fields
    $sql = "SELECT * FROM job_seeker WHERE experience_1 LIKE ? OR experience_2 LIKE ? OR experience_3 LIKE ?";

    // Prepare the SQL statement
    if (!$stmt = $conn->prepare($sql)) {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Bind parameters for LIKE
    $experienceLike = "%" . $category . "%";

    // Bind parameters for the query (3 parameters for 3 `LIKE` clauses)
    $stmt->bind_param("sss", $experienceLike, $experienceLike, $experienceLike);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Display the job seekers in cards
        echo "<div class='job-seeker-container'>";
        while ($row = $result->fetch_assoc()) {
            // Variables from the database
            $jobSeekerImg = $row['job_seeker_img'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $js_id = $row['js_id']; // Job seeker ID

            // Output job seeker card
            echo "<div class='job-seeker-card'>
        <img class='job-seeker-img' src='../job_seeker/$jobSeekerImg' alt='$fname $lname'>
        <h3>$fname $lname</h3>
        <a href='view_job_seeker.php?js_id=$js_id' class='view-btn'>View</a>
      </div>";
        }
        echo "</div>";
    } else {
        echo "<p>No job seekers found for this category.</p>";
    }
}
?>
<style>
    /* Basic reset for the page */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f9;
        color: #333;
        padding: 20px;
    }

    /* Container for the job seekers */
    .job-seeker-container {
        margin-top: 100px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        gap: 20px;
    }

    /* Individual job seeker card */
    .job-seeker-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 250px;
        text-align: center;
        padding: 20px;
        transition: transform 0.3s ease-in-out;
        text-decoration: none;
    }

    .job-seeker-card:hover {
        transform: translateY(-10px);
    }

    /* Circular image */
    .job-seeker-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 3px solid #ccc;
        /* Optional: adds a border around the image */
    }

    /* Job seeker name */
    .job-seeker-card h3 {
        font-size: 18px;
        color: #333;
        margin-bottom: 10px;
        font-weight: bold;
    }

    /* View button */
    .view-btn {
        display: inline-block;
        padding: 8px 15px;
        background-color: #3498db;
        color: white;
        border-radius: 20px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease-in-out;
    }

    .view-btn:hover {
        background-color: #2980b9;
    }

    /* Message when no job seekers are found */
    p {
        text-align: center;
        font-size: 18px;
        color: #888;
    }
</style>
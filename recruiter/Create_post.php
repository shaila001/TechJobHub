
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a Job Post</title>
    <link rel="stylesheet" href="./Create_post.css">
    <link rel="icon" type="image/png" href="./images/logo.png">

    <!-- <script src="../js/Create_post.js"></script> -->
</head>

<body>
    <div class="container">
        <form method="POST" action="post_create.php" class="job-post-form">
            <div class="section job-details">
                <h2 style="text-align: center;">Job Details</h2>
                <label for="job-title">Job Title*:</label>
                <input type="text" id="job-title" name="title" required>

                <label for="about">Description*:</label>
                <textarea id="about" name="description" required></textarea>

                <label for="location">Company’s Location*:</label>
                <input type="text" id="location" name="location" required>

                <label for="responsibilities">Key Responsibilities*:</label>
                <textarea id="responsibilities" name="key_responsibilities" required></textarea>

                <label for="education">Educational Requirements:</label>
                <input type="text" id="education" name="education_requirement">

                <label for="qualifications">Qualification & Experience*:</label>
                <textarea id="qualifications" name="years_experience" required></textarea>

                <label for="deadline">Deadline*:</label>
                <input type="date" id="deadline" name="deadline" required>

                <label for="job-type">Job Type*:</label>
                <select id="job-type" name="job_type" required>
                    <option value="Full Time">Full Time</option>
                    <option value="Part Time">Part Time</option>
                </select>
            </div>

            <button type="submit" class="submit-button">Submit</button>
        </form>
    </div>
    <script src="./load_job_titlie.js"></script>
</body>

</html>

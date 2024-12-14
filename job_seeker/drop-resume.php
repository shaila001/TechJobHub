<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Resume</title>
    <link rel="stylesheet" href="./drop_resume.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="./images/logo.png">

</head>
<body>
    <div class="resume-container">
        <header>
            <h1>Upload Your Resume</h1>
            <p>Upload your resume in PDF format.</p>
        </header>
        
        <div class="upload-section">
            <form method="POST" action="upload_resume.php" enctype="multipart/form-data">
                <label for="resume" class="upload-label">
                    <i class="fas fa-cloud-upload-alt"></i> Drop Resume (PDF Only)
                </label>
                <input type="file" name="resume" id="resume" accept="application/pdf" required />
                <button type="submit" class="submit-btn">Upload Resume</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
session_start();
include "../DB_Connection/DB_connection.php";

// Ensure that the r_id is set in the session
if (isset($_SESSION['r_id'])) {
    // Get the r_id from the session
    $r_id = $_SESSION['r_id'];

    $sql = "SELECT fname, recruiter_img FROM recruiter WHERE r_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $r_id); // "i" for integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $fname = $row['fname'];
        $recruiter_img = $row['recruiter_img'];
    } else {
        $fname = "Guest";
        $recruiter_img = null;
    }
    $stmt->close();
} else {
    header("Location: login.php");
    exit();
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TechJobHub</title>
    <!-- <link rel="stylesheet" href="../css/Dashboard.css" /> -->
    <link rel="stylesheet" href="../css/Dash.css">
    <link rel="stylesheet" href="./Profile_name.css">
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        rel="stylesheet" />
    <style>
        .profile-img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <img src="../images/logo.png" alt="TechJobHub Logo" />
                <h1>TechJobHub</h1>
            </div>
            <div class="nav-links">
                <a href="./Dashboard.php">Home</a>
                <a href="../about_us.php">About Us</a>
                <a href="../contact.php">Contact</a>
            </div>
            <div class="nav-icons">
                <a href="#" title="Search" class="icon search-icon" id="search-icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="white">
                        <path
                            d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zM9.5 14C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                    </svg>
                </a>

                <!-- Search Bar -->
                <div class="search-bar-container" id="search-bar-container">
                    <input
                        type="text"
                        class="search-bar"
                        id="search-bar"
                        placeholder="Search..." />
                    <button class="close-btn" id="close-btn">&times;</button>
                </div>
                <a href="./Menu.php" title="Profile">
                    <span class="profile-name"><?php echo htmlspecialchars($fname); ?></span>
                </a>


                <!-- Profile Section -->
                <a href="#" title="Profile">
                    <?php if ($recruiter_img): ?>
                        <img src="./<?php echo htmlspecialchars($recruiter_img); ?>" alt="Profile Image" class="profile-img">
                    <?php else: ?>
                        <a href="#" title="Profile" class="icon profile-icon" aria-label="Profile">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </a>
                <div class="nav-links">
                    <a href="../logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>

                <a href="./Menu.php" title="Menu" class="icon menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                        <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z" />
                    </svg>
                </a>
            </div>
        </nav>
    </header>
</body>

</html>
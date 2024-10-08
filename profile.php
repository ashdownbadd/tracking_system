<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: signin.html"); // Redirect to sign-in page if not logged in
    exit();
}

// Retrieve user data from session
$username = $_SESSION['username'];
$section = $_SESSION['section'];
$program = $_SESSION['program'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="profile.css">

    <title>Profile</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card__border">
                <img src="student.jpg" alt="card image" class="card__img">
            </div>

            <h3 class="card__name"><?php echo htmlspecialchars($username); ?></h3>
            <span class="card__profession"><?php echo htmlspecialchars($program . ' - ' . $section); ?></span>

            <div class="card__social" id="card-social">
                <div class="card__social-control">
                    <!-- Toggle button -->
                    <div class="card__social-toggle" id="card-toggle">
                        <i class="ri-add-line"></i>
                    </div>

                    <span class="card__social-text">See More</span>

                    <!-- Card social -->
                    <ul class="card__social-list">
                        <a href="update.html" target="_blank" class="card__social-link">
                            <i class="fas fa-pen"></i>
                        </a>

                        <a href="emergency.html" target="_blank" class="card__social-link">
                            <i class="fas fa-medkit"></i>
                        </a>

                        <a href="signin.php" class="card__social-link">
                            <i class="fas fa-power-off"></i>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--=============== MAIN JS ===============-->
    <script src="profile.js"></script>
</body>
</html>

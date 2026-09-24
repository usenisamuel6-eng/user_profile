<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $pageTitle ?? 'My Profile' ?></title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header class="topbar">
    <div class="container nav">

        <a href="profile.php" class="logo">
            <i class="fa-solid fa-user-circle"></i>
            MyProfile
        </a>

        <?php if (isset($_SESSION['user_id'])): ?>

            <div class="nav-links">
                <a href="profile.php">
                    <i class="fa-solid fa-user"></i>
                    Profile
                </a>

                <a href="logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </div>

        <?php endif; ?>

    </div>
</header>

<main class="container">
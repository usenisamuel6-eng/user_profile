<?php

$pageTitle = "MyProfile";

include "includes/header.php";

?>

<section class="hero">

    <div class="hero-content">

        <div class="hero-icon">
            <i class="fa-solid fa-user"></i>
        </div>

        <h1>Manage Your Profile</h1>

        <p>
            Keep your personal information up to date,
            manage your contact details and profile picture
            from one place.
        </p>

        <div class="hero-actions">

            <?php if (isset($_SESSION["user_id"])): ?>

                <a href="modules/profile.php" class="btn btn-primary">
                    <i class="fa-solid fa-user"></i>
                    View Profile
                </a>

            <?php else: ?>

                <a href="modules/login.php" class="btn btn-primary">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    View profie
                </a>
                
                <a href="modules/register.php" class="btn btn-light">
                    <i class="fa-solid fa-user-plus"></i>
                    Create profile
                </a>

            <?php endif; ?>

        </div>

    </div>

</section>

<?php include "includes/footer.php"; ?>
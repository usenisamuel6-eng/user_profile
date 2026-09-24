<?php

require_once "../config/db_connection.php";
require_once "../includes/authentication.php";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    

    <?php
$pageTitle = "My Profile";

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT id, full_name, email, phone, gender, date_of_birth,
            address, city, state, country, profile_image,
            created_at, updated_at
     FROM users
     WHERE id = ?"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$user = $result->fetch_assoc();

include "../includes/header.php";

?>

<div class="profile-card">

    <!-- Profile Header -->

    <div class="profile-header">

        <?php if (!empty($user["profile_image"])): ?>

            <img
                src="uploads/profiles/<?= htmlspecialchars($user["profile_image"]) ?>"
                alt="Profile Picture"
                class="profile-image"
            >

        <?php else: ?>

            <div class="default-profile-image">
                <i class="fa-solid fa-user"></i>
            </div>

        <?php endif; ?>

        <h1 class="profile-name">
            <?= htmlspecialchars($user["full_name"]) ?>
        </h1>

        <p class="profile-email">
            <?= htmlspecialchars($user["email"]) ?>
        </p>

    </div>


    <!-- Profile Information -->

    <div class="profile-body">

        <h2 class="section-title">
            Personal Information
        </h2>

        <div class="info-grid">

            <div class="info-item">

                <span>Full Name</span>

                <strong>
                    <?= htmlspecialchars($user["full_name"]) ?>
                </strong>

            </div>


            <div class="info-item">

                <span>Email Address</span>

                <strong>
                    <?= htmlspecialchars($user["email"]) ?>
                </strong>

            </div>


            <div class="info-item">

                <span>Phone Number</span>

                <strong>
                    <?= !empty($user["phone"])
                        ? htmlspecialchars($user["phone"])
                        : "Not provided" ?>
                </strong>

            </div>


            <div class="info-item">

                <span>Gender</span>

                <strong>
                    <?= !empty($user["gender"])
                        ? htmlspecialchars($user["gender"])
                        : "Not provided" ?>
                </strong>

            </div>


            <div class="info-item">

                <span>Date of Birth</span>

                <strong>
                    <?php

                    if (!empty($user["date_of_birth"])) {
                        echo date(
                            "d M Y",
                            strtotime($user["date_of_birth"])
                        );
                    } else {
                        echo "Not provided";
                    }

                    ?>
                </strong>

            </div>


            <div class="info-item">
                <span>Country</span>

                <strong>
                    <?= !empty($user["country"])
                        ? htmlspecialchars($user["country"])
                        : "Not provided" ?>
                </strong>

            </div>


            <div class="info-item">

                <span>City</span>

                <strong>
                    <?= !empty($user["city"])
                        ? htmlspecialchars($user["city"])
                        : "Not provided" ?>
                </strong>

            </div>


            <div class="info-item">

                <span>State</span>

                <strong>
                    <?= !empty($user["state"])
                        ? htmlspecialchars($user["state"])
                        : "Not provided" ?>
                </strong>

            </div>


            <div class="info-item">

                <span>Address</span>

                <strong>
                    <?= !empty($user["address"])
                        ? htmlspecialchars($user["address"])
                        : "Not provided" ?>
                </strong>

            </div>

        </div>


        <!-- Buttons -->
        <div class="actions">
            <a href="edit_profile.php" class="btn btn-primary">
                <i class="fa-solid fa-pen"></i>
                Edit Profile
            </a>


            <a href="delete_account.php" class="btn btn-danger">
                <i class="fa-solid fa-trash"></i>
                Delete Profile
            </a>
        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
<?php
session_start();
require_once "../config/db_connection.php";
require_once "../includes/authentication.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php


$pageTitle = "Edit Profile";

$user_id = $_SESSION["user_id"];
$error = "";
$success = "";


//get current user data

$stmt = $conn->prepare(
    "SELECT *
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


//update user profile
function clean($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = clean($_POST["full_name"]);
    $email = clean($_POST["email"]);
    $phone = clean($_POST["phone"]);
    $gender = clean($_POST["gender"]);
    $date_of_birth = $_POST["date_of_birth"];
    $address = clean($_POST["address"]);
    $city = clean($_POST["city"]);
    $state = clean($_POST["state"]);
    $country = clean($_POST["country"]);


  //validation

    if (empty($full_name) || empty($email)) {

        $error = "Full name and email are required.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

       

        $check = $conn->prepare(
            "SELECT id
             FROM users
             WHERE email = ?
             AND id != ?"
        );

        $check->bind_param("si", $email, $user_id);
        $check->execute();

        $check_result = $check->get_result();


        if ($check_result->num_rows > 0) {

            $error = "That email address is already being used.";

        } else {

        //keeep the current profile image if no new image is uploaded
            $profile_image = $user["profile_image"];


          //handle profile image upload

            if (
                isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] === UPLOAD_ERR_OK
            ) {

                $file = $_FILES["profile_image"];

                $allowed_types = [
                    "image/jpeg",
                    "image/jpg",
                    "image/png",
                    "image/webp"
                ];

                if (!in_array($file["type"], $allowed_types)) {

                    $error = "Only JPEG, JPG, PNG and WEBP images are allowed.";

                } elseif ($file["size"] > 5 * 1024 * 1024) {

                    $error = "Image size must not be more than 5MB.";

                } else {

                  //upload folder
                    $upload_directory = "uploads/profiles/";

                    if (!is_dir($upload_directory)) {
                        mkdir($upload_directory, 0777, true);
                    }


                   //generate unique file name
                    $extension = strtolower(
                        pathinfo($file["name"], PATHINFO_EXTENSION)
                    );

                    $new_file_name =
                        "user_" .
                        $user_id .
                        "_" .
                        uniqid() .
                        "." .
                        $extension;


                    $upload_path =
                        $upload_directory . $new_file_name;


                  //move the uploaded file to the upload directory

                    if (move_uploaded_file(
                        $file["tmp_name"],
                        $upload_path
                    )) {

                       //delete the old profile image if it exists

                        if (!empty($user["profile_image"]) && file_exists($upload_directory . $user["profile_image"] )) {
                            unlink(
                                $upload_directory . $user["profile_image"]
                            );
                        }

                        $profile_image = $new_file_name;

                    } else {

                        $error = "Failed to upload the image.";
                    }
                }
            }

//update user data in the database
            if (empty($error)) {

                $stmt = $conn->prepare(
                    "UPDATE users SET
                        full_name = ?,
                        email = ?,
                        phone = ?,
                        gender = ?,
                        date_of_birth = ?,
                        address = ?,
                        city = ?,
                        state = ?,
                        country = ?,
                        profile_image = ?
                     WHERE id = ?"
                );

                $stmt->bind_param(
                    "ssssssssssi",
                    $full_name,
                    $email,
                    $phone,
                    $gender,
                    $date_of_birth,
                    $address,
                    $city,
                    $state,
                    $country,
                    $profile_image,
                    $user_id
                );


                if ($stmt->execute()) {

                    header("Location: profile.php?updated=1");
                    exit;

                } else {

                    $error = "Failed to update your profile.";
                }
            }
        }
    }
}


include "../includes/header.php";

?>

<div class="form-card">

    <div class="form-title">

        <h2>Edit Profile</h2>

        <p>
            Update your personal information.
        </p>

    </div>


    <?php if ($error): ?>

        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>


    <form method="POST" enctype="multipart/form-data">

        <!-- Profile Image -->

      <div class="image-upload">

    <?php if (!empty($user["profile_image"])): ?>

        <img
            src="uploads/profiles/<?= htmlspecialchars($user["profile_image"]) ?>"
            alt="Profile Picture"
        >

    <?php else: ?>

        <div class="default-profile-image">
            <i class="fa-solid fa-user"></i>
        </div>

    <?php endif; ?>


    <div class="image-upload-info">

        <strong>Profile Picture</strong>

        <span>
            JPG, PNG or WEBP. Maximum size 2MB.
        </span>

        <input
            type="file"
            id="profile_image"
            name="profile_image"
            accept="image/jpeg,image/png,image/webp"
        >

    </div>

</div>
</div>
            <!-- Full Name -->

            <div class="form-group">

                <label>Full Name</label>

                <input
                    type="text"
                    name="full_name"
                    value="<?= htmlspecialchars($user["full_name"]) ?>"
                    required
                >

            </div>


            <!-- Email -->

            <div class="form-group">

                <label>Email Address</label>

                <input
                    type="email"
                    name="email"
                    value="<?= htmlspecialchars($user["email"]) ?>"
                    required
                >

            </div>


            <!-- Phone -->

            <div class="form-group">

                <label>Phone Number</label>

                <input
                    type="text"
                    name="phone"
                    value="<?= htmlspecialchars($user["phone"] ?? "") ?>"
                >

            </div>


            <!-- Gender -->

            <div class="form-group">

                <label>Gender</label>

                <select name="gender">

                    <option value="">
                        Select gender
                    </option>

                    <option
                        value="Male"
                        <?= $user["gender"] === "Male" ? "selected" : "" ?>
                    >
                        Male
                    </option>

                    <option
                        value="Female"
                        <?= $user["gender"] === "Female" ? "selected" : "" ?>
                    >
                        Female
                    </option>

                </select>

            </div>


            <!-- Date of Birth -->

            <div class="form-group">

                <label>Date of Birth</label>

                <input
                    type="date"
                    name="date_of_birth"
                    value="<?= htmlspecialchars($user["date_of_birth"] ?? "") ?>"
                >

            </div>


            <!-- Country -->

            <div class="form-group">

                <label>Country</label>

                <input
                    type="text"
                    name="country"
                    value="<?= htmlspecialchars($user["country"] ?? "Nigeria") ?>"
                >

            </div>


            <!-- Address -->

            <div class="form-group full">

                <label>Address</label>

                <input
                    type="text"
                    name="address"
                    value="<?= htmlspecialchars($user["address"] ?? "") ?>"
                    placeholder="Enter your address"
                >

            </div>


            <!-- City -->

            <div class="form-group">

                <label>City</label>

                <input
                    type="text"
                    name="city"
                    value="<?= htmlspecialchars($user["city"] ?? "") ?>"
                    placeholder="Enter your city"
                >

            </div>


            <!-- State -->

            <div class="form-group">

                <label>State</label>

                <input
                    type="text"
                    name="state"
                    value="<?= htmlspecialchars($user["state"] ?? "") ?>"
                    placeholder="Enter your state"
                >

            </div>

        </div>


        <!-- Buttons -->

        <div class="form-actions">

            <a href="profile.php" class="btn btn-light">

                <i class="fa-solid fa-arrow-left"></i>

                Cancel

            </a>

            <button type="submit" class="btn btn-primary">

                <i class="fa-solid fa-check"></i>

                Save Changes

            </button>

        </div>

    </form>

</div>
    </div>

<?php include "../includes/footer.php"; ?>
</body>
</html>

<?php

require_once "../config/db_connection.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["user_id"])) {
    header("Location: profile.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    

<?php
$pageTitle = "Login";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {

        $error = "Please enter your email and password.";

    } else {

        $stmt = $conn->prepare(
            "SELECT id, full_name, pwd
             FROM users
             WHERE email = ?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["pwd"])) {

                $_SESSION["user_id"] = $user["id"];

                header("Location: profile.php");
                exit;

            } else {
                $error = "Invalid email or password.";
            }

        } else {
            $error = "Invalid email or password.";
        }
    }
}

include "../includes/header.php";
?>

<div class="auth-card">

    <div class="auth-header">
        <h2>Welcome back</h2>
        <p>Login to manage your profile.</p>
    </div>

    <?php if (isset($_GET["registered"])): ?>

        <div class="alert alert-success">
            Account created successfully. You can now login.
        </div>

    <?php endif; ?>

    <?php if ($error): ?>

        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="form-group">
            <label>Email Address</label>

            <input
                type="email"
                name="email"
                placeholder="Enter your email"
                required
            >
        </div>

        <div class="form-group">
            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter your password"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-right-to-bracket"></i>
            Login
        </button>

    </form>

    <div class="auth-footer">
        Don't have profile?
        <a href="register.php">Create profile</a>
    </div>

</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
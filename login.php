<?php
require_once "db.php";

$pageTitle = "Login";
$activePage = "login";
$errorMessage = "";
$email = "";
$nextPage = $_POST["next"] ?? $_GET["next"] ?? "index.php";

// Only allow these local pages as the post-login destination.
if (!in_array($nextPage, ["index.php", "registration.php"], true)) {
    $nextPage = "index.php";
}

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $databaseError === "") {
    $email = strtolower(trim($_POST["email"] ?? ""));
    $password = $_POST["password"] ?? "";
    $postedToken = $_POST["csrf_token"] ?? "";

    if (!hash_equals($_SESSION["csrf_token"], $postedToken)) {
        $errorMessage = "The form expired. Please reload the page and try again.";
    } elseif ($email === "" || $password === "") {
        $errorMessage = "Enter your email and password.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT user_id, full_name, password_hash FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($userId, $fullName, $passwordHash);

            if ($stmt->fetch() && password_verify($password, $passwordHash)) {
                $stmt->close();
                session_regenerate_id(true);
                $_SESSION["user_id"] = $userId;
                $_SESSION["full_name"] = $fullName;

                header("Location: " . $nextPage);
                exit;
            }

            $stmt->close();
            $errorMessage = "Email or password is incorrect.";
        } catch (mysqli_sql_exception $error) {
            $errorMessage = "We could not log you in. Please check the database setup and try again.";
        }
    }
}

include "header.php";
?>
<main>
    <section class="page-banner"><div class="container"><span class="eyebrow">Welcome back</span><h1>Login</h1><p>Log in to register for CampusConnect events.</p></div></section>
    <section class="section"><div class="container narrow"><div class="form-card reveal">
        <h2>Log In</h2>
        <p class="muted">Use the email and password from your CampusConnect account.</p>

        <?php if ($databaseError !== "") { ?><div class="message error"><?php echo h($databaseError); ?></div><?php } ?>
        <?php if ($errorMessage !== "") { ?><div class="message error"><?php echo h($errorMessage); ?></div><?php } ?>

        <form method="post" action="login.php">
            <input type="hidden" name="csrf_token" value="<?php echo h($_SESSION["csrf_token"]); ?>">
            <input type="hidden" name="next" value="<?php echo h($nextPage); ?>">
            <div class="form-group"><label for="login-email">Email</label><input id="login-email" name="email" type="email" autocomplete="email" value="<?php echo h($email); ?>" required></div>
            <div class="form-group"><label for="login-password">Password</label><input id="login-password" name="password" type="password" autocomplete="current-password" required></div>
            <button class="button primary full" type="submit">Login</button>
        </form>
        <p class="form-switch">New to CampusConnect? <a href="signup.php">Sign Up</a></p>
    </div></div></section>
</main>
<?php include "footer.php"; ?>

<?php
require_once "db.php";

$pageTitle = "Sign Up";
$activePage = "signup";
$errorMessage = "";
$fullName = "";
$email = "";

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $databaseError === "") {
    $fullName = trim($_POST["full_name"] ?? "");
    $email = strtolower(trim($_POST["email"] ?? ""));
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";
    $postedToken = $_POST["csrf_token"] ?? "";

    if (!hash_equals($_SESSION["csrf_token"], $postedToken)) {
        $errorMessage = "The form expired. Please reload the page and try again.";
    } elseif ($fullName === "" || $email === "" || $password === "" || $confirmPassword === "") {
        $errorMessage = "Please complete every field.";
    } elseif (strlen($fullName) > 100) {
        $errorMessage = "Please use a name shorter than 100 characters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Please enter a valid email address.";
    } elseif (strlen($password) < 8) {
        $errorMessage = "Your password must contain at least 8 characters.";
    } elseif ($password !== $confirmPassword) {
        $errorMessage = "The passwords do not match.";
    } else {
        try {
            $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
            $check->bind_param("s", $email);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                $errorMessage = "That email already has an account. Try logging in.";
                $check->close();
            } else {
                $check->close();
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $insert = $conn->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)");
                $insert->bind_param("sss", $fullName, $email, $passwordHash);
                $insert->execute();

                session_regenerate_id(true);
                $_SESSION["user_id"] = $conn->insert_id;
                $_SESSION["full_name"] = $fullName;

                header("Location: index.php");
                exit;
            }
        } catch (mysqli_sql_exception $error) {
            $errorMessage = "We could not create the account. Please check the database setup and try again.";
        }
    }
}

include "header.php";
?>
<main>
    <section class="page-banner"><div class="container"><span class="eyebrow">Join the community</span><h1>Sign Up</h1><p>Create a CampusConnect account to register your interest in student events.</p></div></section>
    <section class="section"><div class="container narrow"><div class="form-card reveal">
        <h2>Create an Account</h2>
        <p class="muted">Your account details are saved in the CampusConnect database.</p>

        <?php if ($databaseError !== "") { ?><div class="message error"><?php echo h($databaseError); ?></div><?php } ?>
        <?php if ($errorMessage !== "") { ?><div class="message error"><?php echo h($errorMessage); ?></div><?php } ?>

        <form method="post" action="signup.php">
            <input type="hidden" name="csrf_token" value="<?php echo h($_SESSION["csrf_token"]); ?>">
            <div class="form-group"><label for="signup-name">Full name</label><input id="signup-name" name="full_name" type="text" maxlength="100" autocomplete="name" value="<?php echo h($fullName); ?>" required></div>
            <div class="form-group"><label for="signup-email">Email</label><input id="signup-email" name="email" type="email" maxlength="190" autocomplete="email" value="<?php echo h($email); ?>" required></div>
            <div class="form-group"><label for="signup-password">Password</label><input id="signup-password" name="password" type="password" minlength="8" autocomplete="new-password" required><small>Use at least 8 characters.</small></div>
            <div class="form-group"><label for="signup-confirm">Confirm password</label><input id="signup-confirm" name="confirm_password" type="password" minlength="8" autocomplete="new-password" required></div>
            <button class="button primary full" type="submit">Create Account</button>
        </form>
        <p class="form-switch">Already have an account? <a href="login.php">Login</a></p>
    </div></div></section>
</main>
<?php include "footer.php"; ?>

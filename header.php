<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($activePage)) {
    $activePage = "";
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | CampusConnect</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
<header class="site-header">
    <div class="container nav-container">
        <a class="brand" href="index.php"><span class="brand-mark">CC</span> CampusConnect</a>
        <input class="menu-toggle" type="checkbox" id="menu-toggle">
        <label class="menu-button" for="menu-toggle">☰ Menu</label>
        <nav class="site-nav" aria-label="Main navigation">
            <a class="<?php echo $activePage === 'home' ? 'active' : ''; ?>" href="index.php">Home</a>
            <a class="<?php echo $activePage === 'gallery' ? 'active' : ''; ?>" href="gallery.php">Gallery</a>
            <a class="<?php echo $activePage === 'events' ? 'active' : ''; ?>" href="events.php">Events</a>
            <a class="<?php echo $activePage === 'registration' ? 'active' : ''; ?>" href="registration.php">Registration</a>
            <a class="<?php echo $activePage === 'contact' ? 'active' : ''; ?>" href="contact.php">Contact Us</a>
            <?php if (isset($_SESSION["user_id"])) { ?>
                <span class="user-welcome">Hi, <?php echo htmlspecialchars($_SESSION["full_name"], ENT_QUOTES, "UTF-8"); ?></span>
                <a class="nav-login" href="logout.php">Logout</a>
            <?php } else { ?>
                <a class="nav-signup <?php echo $activePage === 'signup' ? 'active' : ''; ?>" href="signup.php">Sign Up</a>
                <a class="nav-login <?php echo $activePage === 'login' ? 'active' : ''; ?>" href="login.php">Login</a>
            <?php } ?>
        </nav>
    </div>
</header>

<?php
// Start a session so the website can remember a logged-in user.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Create a form token to help protect form submissions.
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// XAMPP default settings: username root and no password.
// If you set a MySQL password, replace the empty string below.
$databaseName = "campusconnect";
$databaseError = "";
$conn = null;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli("localhost", "root", "", $databaseName);
    $conn->set_charset("utf8mb4");

    // Check that the SQL setup has created the tables used by this project.
    $requiredTables = ["users", "events", "registrations", "contact_messages"];

    foreach ($requiredTables as $tableName) {
        $tableResult = $conn->query("SHOW TABLES LIKE '" . $tableName . "'");

        if ($tableResult->num_rows === 0) {
            $databaseError = "Database tables are missing. Import database_update.sql in phpMyAdmin, then reload this page.";
            break;
        }
    }
} catch (mysqli_sql_exception $error) {
    $conn = null;
    $databaseError = "Cannot connect to MySQL. Start MySQL in XAMPP and check the settings in db.php.";
}

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}
?>

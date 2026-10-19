<?php
require_once "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php?next=registration.php");
    exit;
}

$pageTitle = "Registration";
$activePage = "registration";
$errorMessage = "";
$successMessage = "";
$studentId = "";
$phone = "";
$note = "";
$userId = (int)$_SESSION["user_id"];

if (isset($_SESSION["registration_success"])) {
    $successMessage = $_SESSION["registration_success"];
    unset($_SESSION["registration_success"]);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $databaseError === "") {
    $eventId = (int)($_POST["event_id"] ?? 0);
    $studentId = trim($_POST["student_id"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $note = trim($_POST["note"] ?? "");
    $postedToken = $_POST["csrf_token"] ?? "";

    if (!hash_equals($_SESSION["csrf_token"], $postedToken)) {
        $errorMessage = "The form expired. Please reload the page and try again.";
    } elseif ($eventId < 1 || $studentId === "" || $phone === "") {
        $errorMessage = "Choose an event and complete the required fields.";
    } elseif (strlen($studentId) > 40 || strlen($phone) > 30 || strlen($note) > 1000) {
        $errorMessage = "One of the fields is too long. Please shorten it and try again.";
    } else {
        $transactionStarted = false;

        try {
            $conn->begin_transaction();
            $transactionStarted = true;

            // Lock the event row while checking seats, so capacity is respected.
            $eventCheck = $conn->prepare("SELECT capacity FROM events WHERE event_id = ? AND status = 'Open' AND event_date >= CURDATE() FOR UPDATE");
            $eventCheck->bind_param("i", $eventId);
            $eventCheck->execute();
            $eventCheck->bind_result($capacity);
            $eventExists = $eventCheck->fetch();
            $eventCheck->close();

            if (!$eventExists) {
                $errorMessage = "That event is not available for registration.";
            } else {
                $duplicateCheck = $conn->prepare("SELECT registration_id FROM registrations WHERE user_id = ? AND event_id = ?");
                $duplicateCheck->bind_param("ii", $userId, $eventId);
                $duplicateCheck->execute();
                $duplicateCheck->store_result();
                $alreadyRegistered = $duplicateCheck->num_rows > 0;
                $duplicateCheck->close();

                if ($alreadyRegistered) {
                    $errorMessage = "You have already registered for this event.";
                } else {
                    $countCheck = $conn->prepare("SELECT COUNT(*) FROM registrations WHERE event_id = ?");
                    $countCheck->bind_param("i", $eventId);
                    $countCheck->execute();
                    $countCheck->bind_result($registeredCount);
                    $countCheck->fetch();
                    $countCheck->close();

                    if ($registeredCount >= $capacity) {
                        $errorMessage = "Sorry, this event is full.";
                    } else {
                        $insert = $conn->prepare("INSERT INTO registrations (user_id, event_id, student_id, phone, note) VALUES (?, ?, ?, ?, ?)");
                        $insert->bind_param("iisss", $userId, $eventId, $studentId, $phone, $note);
                        $insert->execute();
                        $insert->close();
                    }
                }
            }

            if ($errorMessage === "") {
                $conn->commit();
                $_SESSION["registration_success"] = "Your event registration has been saved.";
                header("Location: registration.php");
                exit;
            }

            $conn->rollback();
            $transactionStarted = false;
        } catch (mysqli_sql_exception $error) {
            if ($transactionStarted) {
                $conn->rollback();
            }
            $errorMessage = "We could not save your registration. Please try again.";
        }
    }
}

$eventRows = [];
if ($databaseError === "") {
    try {
        $eventResult = $conn->query("SELECT event_id, event_name, event_date, event_time, venue FROM events WHERE status = 'Open' AND event_date >= CURDATE() ORDER BY event_date");
        while ($event = $eventResult->fetch_assoc()) {
            $eventRows[] = $event;
        }
    } catch (mysqli_sql_exception $error) {
        $databaseError = "Could not load the events. Please check that the SQL setup file was imported.";
    }
}

include "header.php";
?>
<main>
    <section class="page-banner"><div class="container"><span class="eyebrow">Join a campus activity</span><h1>Registration</h1><p>Choose an event and send your registration to the CampusConnect database.</p></div></section>
    <section class="section"><div class="container narrow"><div class="form-card reveal">
        <h2>Event Registration</h2>
        <p class="muted">Logged in as <?php echo h($_SESSION["full_name"]); ?>.</p>

        <?php if ($databaseError !== "") { ?><div class="message error"><?php echo h($databaseError); ?></div><?php } ?>
        <?php if ($errorMessage !== "") { ?><div class="message error"><?php echo h($errorMessage); ?></div><?php } ?>
        <?php if ($successMessage !== "") { ?><div class="message success"><?php echo h($successMessage); ?></div><?php } ?>

        <?php if ($databaseError === "") { ?>
            <?php if (count($eventRows) > 0) { ?>
                <form method="post" action="registration.php">
                    <input type="hidden" name="csrf_token" value="<?php echo h($_SESSION["csrf_token"]); ?>">
                    <div class="form-group"><label for="reg-event">Choose an event</label><select id="reg-event" name="event_id" required><option value="">Select an event</option>
                        <?php foreach ($eventRows as $event) { ?>
                            <option value="<?php echo (int)$event["event_id"]; ?>" <?php echo ((int)($_POST["event_id"] ?? 0) === (int)$event["event_id"]) ? "selected" : ""; ?>><?php echo h($event["event_name"]); ?> — <?php echo h($event["event_date"]); ?>, <?php echo h(substr($event["event_time"], 0, 5)); ?> at <?php echo h($event["venue"]); ?></option>
                        <?php } ?>
                    </select></div>
                    <div class="form-row"><div class="form-group"><label for="reg-student-id">Student ID</label><input id="reg-student-id" name="student_id" type="text" maxlength="40" value="<?php echo h($studentId); ?>" required></div><div class="form-group"><label for="reg-phone">Phone number</label><input id="reg-phone" name="phone" type="tel" maxlength="30" value="<?php echo h($phone); ?>" required></div></div>
                    <div class="form-group"><label for="reg-note">Note (optional)</label><textarea id="reg-note" name="note" rows="4" maxlength="1000"><?php echo h($note); ?></textarea></div>
                    <button class="button primary" type="submit">Save Registration</button>
                </form>
            <?php } else { ?>
                <div class="message">There are no open future events in the database yet.</div>
            <?php } ?>
        <?php } ?>
    </div></div></section>
</main>
<?php include "footer.php"; ?>

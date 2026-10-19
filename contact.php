<?php
require_once "db.php";

$pageTitle = "Contact Us";
$activePage = "contact";
$errorMessage = "";
$successMessage = "";
$fullName = "";
$email = "";
$subject = "";
$messageText = "";

$subjectOptions = [
    "acara" => "Pertanyaan tentang acara",
    "pendaftaran" => "Pertanyaan tentang pendaftaran",
    "lain-lain" => "Lain-lain"
];

if (isset($_SESSION["contact_success"])) {
    $successMessage = $_SESSION["contact_success"];
    unset($_SESSION["contact_success"]);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $databaseError === "") {
    $fullName = trim($_POST["full_name"] ?? "");
    $email = strtolower(trim($_POST["email"] ?? ""));
    $subject = $_POST["subject"] ?? "";
    $messageText = trim($_POST["message"] ?? "");
    $postedToken = $_POST["csrf_token"] ?? "";

    if (!hash_equals($_SESSION["csrf_token"], $postedToken)) {
        $errorMessage = "Borang telah tamat tempoh. Muat semula halaman dan cuba lagi.";
    } elseif ($fullName === "" || $email === "" || $subject === "" || $messageText === "") {
        $errorMessage = "Sila lengkapkan semua ruangan.";
    } elseif (strlen($fullName) > 100 || strlen($email) > 190 || strlen($messageText) > 5000) {
        $errorMessage = "Salah satu ruangan terlalu panjang. Sila pendekkan dan cuba lagi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Sila masukkan alamat e-mel yang sah.";
    } elseif (!array_key_exists($subject, $subjectOptions)) {
        $errorMessage = "Sila pilih subjek yang tersedia.";
    } else {
        try {
            $subjectLabel = $subjectOptions[$subject];
            $stmt = $conn->prepare("INSERT INTO contact_messages (full_name, email, subject, message_text) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $fullName, $email, $subjectLabel, $messageText);
            $stmt->execute();
            $stmt->close();

            $_SESSION["contact_success"] = "Terima kasih. Pertanyaan anda telah disimpan.";
            header("Location: contact.php");
            exit;
        } catch (mysqli_sql_exception $error) {
            $errorMessage = "Pertanyaan tidak dapat disimpan. Pastikan jadual contact_messages telah ditambah ke database.";
        }
    }
}

include "header.php";
?>
<main>
    <section class="page-banner"><div class="container"><span class="eyebrow">Kami sedia membantu</span><h1>Contact Us</h1><p>Hantar pertanyaan kepada CampusConnect. Mesej anda akan disimpan dalam database.</p></div></section>
    <section class="section"><div class="container contact-layout">
        <section class="card contact-info reveal"><h2>Maklumat Hubungan</h2><p class="muted">Maklumat ini ialah contoh. Gantikan dengan butiran rasmi kumpulan atau kampus anda.</p>
            <div class="contact-detail"><strong>E-mel</strong><a href="mailto:campusconnect@example.com">campusconnect@example.com</a></div>
            <div class="contact-detail"><strong>Telefon</strong><p>Masukkan nombor telefon rasmi kampus di sini.</p></div>
            <div class="contact-detail"><strong>Lokasi</strong><p>Unit Hal Ehwal Pelajar, kampus anda.</p></div>
            <div class="contact-detail"><strong>Waktu operasi</strong><p>Isnin hingga Jumaat, waktu pejabat.</p></div>
        </section>
        <section class="form-card reveal"><h2>Borang Pertanyaan</h2><p class="muted">Isi ruangan di bawah. Pertanyaan yang berjaya dihantar akan disimpan.</p>
            <?php if ($databaseError !== "") { ?><div class="message error"><?php echo h($databaseError); ?></div><?php } ?>
            <?php if ($errorMessage !== "") { ?><div class="message error"><?php echo h($errorMessage); ?></div><?php } ?>
            <?php if ($successMessage !== "") { ?><div class="message success"><?php echo h($successMessage); ?></div><?php } ?>
            <form method="post" action="contact.php">
                <input type="hidden" name="csrf_token" value="<?php echo h($_SESSION["csrf_token"]); ?>">
                <div class="form-row"><div class="form-group"><label for="contact-name">Nama</label><input id="contact-name" name="full_name" type="text" maxlength="100" autocomplete="name" value="<?php echo h($fullName); ?>" required></div><div class="form-group"><label for="contact-email">E-mel</label><input id="contact-email" name="email" type="email" maxlength="190" autocomplete="email" value="<?php echo h($email); ?>" required></div></div>
                <div class="form-group"><label for="contact-subject">Subjek</label><select id="contact-subject" name="subject" required><option value="">Pilih subjek</option>
                    <?php foreach ($subjectOptions as $value => $label) { ?>
                        <option value="<?php echo h($value); ?>" <?php echo $subject === $value ? "selected" : ""; ?>><?php echo h($label); ?></option>
                    <?php } ?>
                </select></div>
                <div class="form-group"><label for="contact-message">Mesej</label><textarea id="contact-message" name="message" rows="5" maxlength="5000" required><?php echo h($messageText); ?></textarea></div>
                <button class="button primary" type="submit">Hantar Pertanyaan</button>
                <p class="form-note">Borang ini menyimpan nama, e-mel, subjek dan mesej ke dalam jadual contact_messages. Ia tidak menghantar e-mel.</p>
            </form>
        </section>
    </div></section>
</main>
<?php include "footer.php"; ?>

<?php
$pageTitle = "Events";
$activePage = "events";
include "header.php";

$events = [
    ["Seminar Kerjaya Pelajar", "Seminar", "2026-11-05", "10:00 pagi", "Dewan Utama", "Sesi perkongsian tentang persediaan kerjaya dan kemahiran pekerjaan.", "🎤"],
    ["Bengkel Asas Digital", "Bengkel", "2026-11-12", "2:00 petang", "Makmal Komputer 1", "Bengkel pengenalan kepada kemahiran digital untuk pelajar.", "💻"],
    ["Hari Sukan Kolej", "Sukan", "2026-11-18", "8:30 pagi", "Padang Kolej", "Aktiviti sukan untuk menggalakkan kesihatan dan semangat berpasukan.", "🏆"],
    ["Pameran Keusahawanan", "Pameran", "2026-11-25", "9:00 pagi", "Ruang Legar", "Pelajar mempamerkan idea dan produk keusahawanan.", "💡"],
    ["Program Khidmat Masyarakat", "Komuniti", "2026-12-03", "9:00 pagi", "Bilik Aktiviti Pelajar", "Aktiviti sukarelawan bersama komuniti setempat.", "🤝"],
    ["Kem Kepimpinan Pelajar", "Kepimpinan", "2026-12-10", "8:00 pagi", "Pusat Aktiviti Kolej", "Aktiviti berkumpulan untuk membina kemahiran kepimpinan.", "🧭"],
    ["Festival Kebudayaan Kampus", "Kebudayaan", "2026-12-16", "5:00 petang", "Dewan Utama", "Persembahan dan aktiviti yang meraikan kepelbagaian budaya.", "🎭"]
];
?>
<main>
    <section class="page-banner"><div class="container"><span class="eyebrow">Kalendar kampus</span><h1>Events</h1><p>Terokai acara contoh dan pilih program yang menarik minat anda.</p></div></section>
    <section class="section"><div class="container grid three">
        <?php foreach ($events as $event) { ?>
            <article class="event-card reveal">
                <div class="event-art blue"><span><?php echo $event[6]; ?></span></div>
                <div class="card-body"><span class="category"><?php echo $event[1]; ?></span><h2><?php echo $event[0]; ?></h2><p><?php echo $event[5]; ?></p>
                    <ul class="event-details"><li><strong>Tarikh:</strong> <?php echo $event[2]; ?></li><li><strong>Masa:</strong> <?php echo $event[3]; ?></li><li><strong>Tempat:</strong> <?php echo $event[4]; ?></li></ul>
                    <a class="button primary full" href="registration.php">Daftar Minat</a>
                </div>
            </article>
        <?php } ?>
    </div></section>
</main>
<?php include "footer.php"; ?>

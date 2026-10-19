<?php
$pageTitle = "Gallery";
$activePage = "gallery";
include "header.php";
$photos = [
    ["gallery-01.jpg", "Hari Suai Kenal", "Program Kolej", "Pelajar baharu berkenalan dengan komuniti kampus.", "🎓"],
    ["gallery-02.jpg", "Seminar Kerjaya", "Seminar", "Perkongsian persediaan memasuki alam pekerjaan.", "🎤"],
    ["gallery-03.jpg", "Hari Sukan Kolej", "Sukan", "Aktiviti sukan dan semangat berpasukan.", "🏆"],
    ["gallery-04.jpg", "Bengkel Komputer", "Bengkel", "Pelajar mencuba kemahiran asas komputer.", "💻"],
    ["gallery-05.jpg", "Program Kolej", "Program", "Aktiviti yang menghimpunkan pelajar kolej.", "🏫"],
    ["gallery-06.jpg", "Aktiviti Sukarelawan", "Komuniti", "Pelajar bekerjasama dalam khidmat masyarakat.", "🤝"],
    ["gallery-07.jpg", "Pertandingan Debat", "Pertandingan", "Peserta mengasah kemahiran komunikasi.", "🗣️"],
    ["gallery-08.jpg", "Bengkel Robotik", "Bengkel", "Pengenalan kepada robot dan teknologi.", "🤖"],
    ["gallery-09.jpg", "Perlawanan Futsal", "Sukan", "Pasukan pelajar beraksi di gelanggang.", "⚽"],
    ["gallery-10.jpg", "Persembahan Budaya", "Kebudayaan", "Persembahan meraikan kepelbagaian budaya.", "🎭"],
    ["gallery-11.jpg", "Kem Kepimpinan", "Kepimpinan", "Aktiviti berkumpulan membina kemahiran memimpin.", "🧭"],
    ["gallery-12.jpg", "Perkongsian Ilmu", "Seminar", "Penceramah berkongsi pengalaman dengan pelajar.", "📚"],
    ["gallery-13.jpg", "Khidmat Masyarakat", "Komuniti", "Pelajar menyumbang tenaga kepada komuniti.", "🌱"],
    ["gallery-14.jpg", "Pameran Keusahawanan", "Pameran", "Pelajar mempamerkan idea dan produk.", "💡"],
    ["gallery-15.jpg", "Pertandingan Badminton", "Sukan", "Pemain bertanding dalam acara badminton.", "🏸"],
    ["gallery-16.jpg", "Festival Kolej", "Program", "Persembahan dan aktiviti pelajar.", "🎉"],
    ["gallery-17.jpg", "Aktiviti Makmal STEM", "Pembelajaran", "Aktiviti sains dan teknologi di makmal.", "🔬"],
    ["gallery-18.jpg", "Majlis Graduasi", "Majlis", "Meraikan pencapaian dan usaha graduan.", "🎓"],
    ["gallery-19.jpg", "Pameran Kelab Pelajar", "Kelab", "Kenali kelab dan persatuan di kampus.", "🌟"],
    ["gallery-20.jpg", "Pesta Buku Kampus", "Pembelajaran", "Terokai buku dan bahan bacaan baharu.", "📖"]
];
?>
<main>
    <section class="page-banner"><div class="container"><span class="eyebrow">Kenangan kampus</span><h1>Gallery Aktiviti</h1><p>Masukkan foto anda ke dalam folder images untuk menggantikan ruang ikon sementara.</p></div></section>
    <section class="section"><div class="container gallery-grid">
        <?php foreach ($photos as $photo) { ?>
            <article class="gallery-card reveal"><div class="gallery-photo"><img src="images/<?php echo $photo[0]; ?>" alt="<?php echo $photo[1]; ?>" loading="lazy"><span class="gallery-fallback" hidden><?php echo $photo[4]; ?></span></div><div class="card-body"><span class="category"><?php echo $photo[2]; ?></span><h2><?php echo $photo[1]; ?></h2><p><?php echo $photo[3]; ?></p></div></article>
        <?php } ?>
    </div></section>
</main>
<?php include "footer.php"; ?>

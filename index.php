<?php
$pageTitle = "Home";
$activePage = "home";
include "header.php";
?>
<main>
    <section class="hero">
        <div class="container hero-layout">
            <div class="reveal">
                <span class="eyebrow">Tempat aktiviti kampus bermula</span>
                <h1>Temui komuniti anda di <span>CampusConnect.</span></h1>
                <p>Ketahui aktiviti kampus, cari program yang diminati dan dapatkan maklumat acara di satu tempat.</p>
                <div class="actions">
                    <a class="button primary" href="events.php">Lihat Acara</a>
                    <a class="button secondary" href="gallery.php">Lihat Gallery</a>
                </div>
            </div>
            <div class="hero-art reveal" aria-label="Banner acara kampus">
                <div class="hero-card"><span class="eyebrow">CAMPUS EVENT</span><div class="big-emoji">🎤</div><h2>Idea bertemu komuniti</h2><p>Seminar · Bengkel · Sukan · Program kolej</p><span class="pill">Jom sertai!</span></div>
                <span class="float-note note-one">Belajar bersama ✨</span>
                <span class="float-note note-two">Aktif di kampus 🏅</span>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container intro-layout">
            <div><span class="eyebrow">Pengenalan</span><h2>Pengalaman kampus yang lebih dekat.</h2></div>
            <div class="muted"><p>CampusConnect ialah laman contoh untuk membantu pelajar mencari maklumat aktiviti kampus dengan mudah.</p><p>Terokai acara pilihan, lihat gambar aktiviti dan hubungi penganjur melalui menu di atas.</p></div>
        </div>
    </section>
    <section class="section pale">
        <div class="container">
            <div class="center-heading"><span class="eyebrow">Objektif projek</span><h2>Direka untuk komuniti kampus.</h2></div>
            <div class="grid three">
                <article class="card reveal"><div class="icon">📅</div><h3>Mencari acara</h3><p>Melihat acara pelajar di satu tempat.</p></article>
                <article class="card reveal"><div class="icon">🤝</div><h3>Menyertai komuniti</h3><p>Menemui aktiviti yang sesuai dengan minat.</p></article>
                <article class="card reveal"><div class="icon">📣</div><h3>Mendapat maklumat</h3><p>Membaca penerangan acara dan cara bertanya.</p></article>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="heading-row"><div><span class="eyebrow">Acara pilihan</span><h2>Ada sesuatu untuk semua.</h2></div><a class="text-link" href="events.php">Lihat semua acara →</a></div>
            <div class="grid three">
                <article class="event-card"><div class="event-art blue">🎤</div><div class="card-body"><span class="category">Seminar</span><h3>Seminar Kerjaya Pelajar</h3><p>Sesi perkongsian tentang persediaan kerjaya.</p></div></article>
                <article class="event-card"><div class="event-art cyan">💻</div><div class="card-body"><span class="category">Bengkel</span><h3>Bengkel Asas Digital</h3><p>Aktiviti pembelajaran kemahiran digital.</p></div></article>
                <article class="event-card"><div class="event-art purple">🏆</div><div class="card-body"><span class="category">Sukan</span><h3>Hari Sukan Kolej</h3><p>Program santai untuk semangat berpasukan.</p></div></article>
            </div>
            <div class="center-action"><a class="button primary" href="events.php">Teroka Semua Acara</a></div>
        </div>
    </section>
    <section class="join-banner"><div class="container heading-row"><h2>Acara kampus seterusnya mungkin untuk anda.</h2><a class="button white" href="registration.php">Lihat Pendaftaran</a></div></section>
</main>
<?php include "footer.php"; ?>

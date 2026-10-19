-- CampusConnect: database and sample event records
-- Import this file in phpMyAdmin using the Import tab.

CREATE DATABASE IF NOT EXISTS campusconnect
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE campusconnect;

CREATE TABLE IF NOT EXISTS events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(120) NOT NULL,
    category VARCHAR(60) NOT NULL,
    description TEXT NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    venue VARCHAR(120) NOT NULL,
    capacity INT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample records. Import this file once to avoid duplicate sample rows.
INSERT INTO events
    (event_name, category, description, event_date, event_time, venue, capacity, status)
VALUES
    ('Seminar Kerjaya Pelajar', 'Seminar', 'Sesi perkongsian tentang persediaan kerjaya dan kemahiran pekerjaan.', '2026-11-05', '10:00:00', 'Dewan Utama', 120, 'Open'),
    ('Bengkel Asas Digital', 'Bengkel', 'Bengkel pengenalan kepada kemahiran digital untuk pelajar.', '2026-11-12', '14:00:00', 'Makmal Komputer 1', 30, 'Open'),
    ('Hari Sukan Kolej', 'Sukan', 'Aktiviti sukan untuk menggalakkan kesihatan dan semangat berpasukan.', '2026-11-18', '08:30:00', 'Padang Kolej', 200, 'Open'),
    ('Pameran Keusahawanan', 'Pameran', 'Pelajar mempamerkan idea dan produk keusahawanan.', '2026-11-25', '09:00:00', 'Ruang Legar', 100, 'Open'),
    ('Program Khidmat Masyarakat', 'Komuniti', 'Aktiviti sukarelawan bersama komuniti setempat.', '2026-12-03', '09:00:00', 'Bilik Aktiviti Pelajar', 40, 'Open'),
    ('Kem Kepimpinan Pelajar', 'Kepimpinan', 'Aktiviti berkumpulan untuk membina kemahiran kepimpinan.', '2026-12-10', '08:00:00', 'Pusat Aktiviti Kolej', 50, 'Open'),
    ('Festival Kebudayaan Kampus', 'Kebudayaan', 'Persembahan dan aktiviti yang meraikan kepelbagaian budaya.', '2026-12-16', '17:00:00', 'Dewan Utama', 180, 'Open');

-- Accounts for sign up and login. Passwords are stored as hashes by PHP.
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Event registrations submitted by logged-in users.
CREATE TABLE IF NOT EXISTS registrations (
    registration_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    student_id VARCHAR(40) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    note TEXT,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_event (user_id, event_id),
    INDEX registrations_event_id (event_id),
    CONSTRAINT fk_registrations_user FOREIGN KEY (user_id) REFERENCES users(user_id),
    CONSTRAINT fk_registrations_event FOREIGN KEY (event_id) REFERENCES events(event_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Questions submitted through the Contact Us page.
CREATE TABLE IF NOT EXISTS contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(190) NOT NULL,
    subject VARCHAR(120) NOT NULL,
    message_text TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- DATABASE: prfict_db
-- Website Rekrutmen & Sistem Informasi Program Representative FICT
-- Horizon University Indonesia
-- =====================================================

CREATE DATABASE IF NOT EXISTS `prfict_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `prfict_db`;

-- =====================================================
-- 1. TABEL: users_admin
-- Akun Administrator Portal PR FICT
-- =====================================================
DROP TABLE IF EXISTS `users_admin`;
CREATE TABLE `users_admin` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Default login admin: admin@prfict.com / 12345
INSERT INTO `users_admin` (`name`, `email`, `password`, `created_at`) VALUES
('Administrator', 'admin@prfict.com', '$2y$10$HBozhI4H3TCJk82Jkc6lVebyKkj1sOFfWu8JoJtxzHgqET8Q6k/86', NOW());

-- =====================================================
-- 2. TABEL: divisions
-- Data Divisi Organisasi PR FICT
-- =====================================================
DROP TABLE IF EXISTS `divisions`;
CREATE TABLE `divisions` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `icon` VARCHAR(50) DEFAULT 'fa-users',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `divisions` (`name`, `description`, `icon`, `is_active`) VALUES
('PSDM', 'Pengembangan Sumber Daya Manusia bertanggung jawab dalam pengembangan potensi dan kualitas anggota organisasi.', 'fa-user-graduate', 1),
('Humas', 'Hubungan Masyarakat bertanggung jawab dalam membangun relasi dan komunikasi dengan pihak eksternal.', 'fa-handshake', 1),
('Media & Kreatif', 'Bertanggung jawab dalam pembuatan konten kreatif, desain grafis, dan pengelolaan media sosial.', 'fa-palette', 1),
('Acara', 'Bertanggung jawab dalam perencanaan, koordinasi, dan pelaksanaan kegiatan organisasi.', 'fa-calendar-check', 1),
('Kominfo', 'Komunikasi dan Informasi bertanggung jawab dalam penyebaran informasi dan dokumentasi kegiatan.', 'fa-bullhorn', 1),
('Advokasi', 'Bertanggung jawab dalam menyalurkan aspirasi mahasiswa dan melakukan advokasi kebijakan.', 'fa-scale-balanced', 1);

-- =====================================================
-- 3. TABEL: student_users
-- Akun Mahasiswa / Pendaftar
-- =====================================================
DROP TABLE IF EXISTS `student_users`;
CREATE TABLE `student_users` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `full_name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `photo` VARCHAR(255) DEFAULT NULL,
    `nim` VARCHAR(20) DEFAULT NULL,
    `birth_place` VARCHAR(100) DEFAULT NULL,
    `birth_date` DATE DEFAULT NULL,
    `gender` ENUM('Laki-laki', 'Perempuan') DEFAULT NULL,
    `phone` VARCHAR(20) DEFAULT NULL,
    `study_program` VARCHAR(100) DEFAULT NULL,
    `class_name` VARCHAR(50) DEFAULT NULL,
    `address` TEXT DEFAULT NULL,
    `organization_experience` TEXT DEFAULT NULL,
    `achievements` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- 4. TABEL: applicants
-- Data Pengajuan Pendaftaran Mahasiswa
-- =====================================================
DROP TABLE IF EXISTS `applicants`;
CREATE TABLE `applicants` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) UNSIGNED DEFAULT NULL,
    `registration_code` VARCHAR(20) NOT NULL,
    `full_name` VARCHAR(150) NOT NULL,
    `nim` VARCHAR(20) NOT NULL,
    `study_program` VARCHAR(100) NOT NULL,
    `semester` TINYINT(2) NOT NULL,
    `gender` ENUM('Laki-laki', 'Perempuan') NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `whatsapp` VARCHAR(20) NOT NULL,
    `division_id` INT(11) UNSIGNED NOT NULL,
    `reason` TEXT NOT NULL,
    `organization_experience` TEXT,
    `skills` TEXT,
    `photo` VARCHAR(255) DEFAULT NULL,
    `cv` VARCHAR(255) DEFAULT NULL,
    `status` ENUM('Menunggu', 'Seleksi Administrasi', 'Interview', 'Lolos', 'Tidak Lolos') NOT NULL DEFAULT 'Menunggu',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `registration_code` (`registration_code`),
    UNIQUE KEY `nim` (`nim`),
    UNIQUE KEY `email` (`email`),
    KEY `user_id` (`user_id`),
    KEY `division_id` (`division_id`),
    KEY `status` (`status`),
    CONSTRAINT `fk_applicant_division` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- 5. TABEL: organization_members
-- Data Pengurus Organisasi PR FICT Kabinet Adhiyakhsa
-- =====================================================
DROP TABLE IF EXISTS `organization_members`;
CREATE TABLE `organization_members` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `position` VARCHAR(100) NOT NULL,
    `division` VARCHAR(100) NOT NULL,
    `photo` VARCHAR(255) DEFAULT NULL,
    `motto` TEXT DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `social_instagram` VARCHAR(100) DEFAULT NULL,
    `social_linkedin` VARCHAR(100) DEFAULT NULL,
    `display_order` INT(11) NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `organization_members` (`name`, `position`, `division`, `photo`, `motto`, `description`, `display_order`, `is_active`) VALUES
('Ketua Organisasi', 'Ketua Umum', 'Pimpinan', NULL, 'Motto kepemimpinan dan integritas organisasi.', 'Memimpin dan mengoordinasikan seluruh jalannya program kerja serta arah strategis organisasi.', 1, 1),
('Wakil Ketua', 'Wakil Ketua', 'Pimpinan', NULL, 'Kolaborasi aktif untuk mencapai visi bersama.', 'Mendampingi Ketua dalam mengoordinasikan bidang kerja dan kelancaran program.', 2, 1),
('Sekretaris 1', 'Sekretaris', 'Sekretariat', NULL, 'Tertib administrasi kunci tata kelola yang baik.', 'Mengelola administrasi, surat-menyurat, dan dokumentasi resmi organisasi.', 3, 1),
('Bendahara 1', 'Bendahara', 'Keuangan', NULL, 'Transparan, akuntabel, dan bertanggung jawab.', 'Mengelola pencatatan anggaran dan pembukuan keuangan organisasi secara teratur.', 4, 1),
('Koordinator Humas', 'Koordinator Divisi', 'Humas', NULL, 'Membangun sinergi dan komunikasi efektif.', 'Membangun relasi eksternal serta menjalin kemitraan strategis dengan berbagai pihak.', 5, 1),
('Koordinator Media', 'Koordinator Divisi', 'Media & Kreatif', NULL, 'Inovasi visual dan publikasi kreatif.', 'Mengelola aset publikasi visual, sosial media, dan informasi kegiatan organisasi.', 6, 1);

-- =====================================================
-- 6. TABEL: program_kerja
-- Data Program Kerja PR FICT
-- =====================================================
DROP TABLE IF EXISTS `program_kerja`;
CREATE TABLE `program_kerja` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama_program` VARCHAR(255) NOT NULL,
    `divisi` VARCHAR(100) NOT NULL,
    `activity` TEXT DEFAULT NULL,
    `target` TEXT DEFAULT NULL,
    `pic` VARCHAR(150) NOT NULL,
    `status` ENUM('Belum Dimulai', 'Berjalan', 'Selesai') NOT NULL DEFAULT 'Belum Dimulai',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- 7. TABEL: program_dokumentasi
-- Foto & Dokumentasi untuk Program Kerja
-- =====================================================
DROP TABLE IF EXISTS `program_dokumentasi`;
CREATE TABLE `program_dokumentasi` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `program_kerja_id` INT(11) UNSIGNED NOT NULL,
    `file_name` VARCHAR(255) NOT NULL,
    `caption` VARCHAR(255) DEFAULT NULL,
    `uploaded_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `program_kerja_id` (`program_kerja_id`),
    CONSTRAINT `fk_dok_program_kerja` FOREIGN KEY (`program_kerja_id`) REFERENCES `program_kerja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- 8. TABEL: pengajuan_pelaksanaan
-- Pengajuan Proposal Pelaksanaan Program Kerja
-- =====================================================
DROP TABLE IF EXISTS `pengajuan_pelaksanaan`;
CREATE TABLE `pengajuan_pelaksanaan` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `nama_program` VARCHAR(255) NOT NULL,
    `divisi` VARCHAR(100) NOT NULL,
    `pic` VARCHAR(150) NOT NULL,
    `tanggal_pelaksanaan` DATE NOT NULL,
    `lokasi` VARCHAR(255) NOT NULL,
    `projek_brief` TEXT NOT NULL,
    `proposal_file` VARCHAR(255) DEFAULT NULL,
    `catatan` TEXT DEFAULT NULL,
    `status` ENUM('Submit', 'Review', 'Revisi', 'Approve') NOT NULL DEFAULT 'Submit',
    `catatan_revisi` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- 9. TABEL: approval_history
-- Riwayat Review & Persetujuan Proposal
-- =====================================================
DROP TABLE IF EXISTS `approval_history`;
CREATE TABLE `approval_history` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `pengajuan_id` INT(11) UNSIGNED NOT NULL,
    `status` VARCHAR(50) NOT NULL,
    `catatan` TEXT DEFAULT NULL,
    `changed_by` VARCHAR(100) NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `pengajuan_id` (`pengajuan_id`),
    CONSTRAINT `fk_history_pengajuan` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuan_pelaksanaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

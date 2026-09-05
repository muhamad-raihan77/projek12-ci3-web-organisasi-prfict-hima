-- =====================================================
-- MIGRATION: Program Kerja & Pengajuan Pelaksanaan
-- Tambahan tabel baru untuk prfict_db
-- TIDAK mengubah tabel yang sudah ada
-- =====================================================

USE `prfict_db`;

-- =====================================================
-- TABEL: program_kerja
-- =====================================================
CREATE TABLE IF NOT EXISTS `program_kerja` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABEL: program_dokumentasi
-- =====================================================
CREATE TABLE IF NOT EXISTS `program_dokumentasi` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `program_kerja_id` INT(11) UNSIGNED NOT NULL,
    `file_name` VARCHAR(255) NOT NULL,
    `caption` VARCHAR(255) DEFAULT NULL,
    `uploaded_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `program_kerja_id` (`program_kerja_id`),
    CONSTRAINT `fk_dok_program_kerja` FOREIGN KEY (`program_kerja_id`) REFERENCES `program_kerja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABEL: pengajuan_pelaksanaan
-- =====================================================
CREATE TABLE IF NOT EXISTS `pengajuan_pelaksanaan` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABEL: approval_history
-- =====================================================
CREATE TABLE IF NOT EXISTS `approval_history` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `pengajuan_id` INT(11) UNSIGNED NOT NULL,
    `status` VARCHAR(50) NOT NULL,
    `catatan` TEXT DEFAULT NULL,
    `changed_by` VARCHAR(100) NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `pengajuan_id` (`pengajuan_id`),
    CONSTRAINT `fk_history_pengajuan` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuan_pelaksanaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABEL: organization_members
-- Fitur Struktur Organisasi PR FICT Kabinet Adhiyakhsa
-- =====================================================

CREATE TABLE IF NOT EXISTS `organization_members` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- DATA DEFAULT: Pengurus PR FICT Kabinet Adhiyakhsa
-- =====================================================

INSERT INTO `organization_members` (`name`, `position`, `division`, `photo`, `motto`, `description`, `display_order`, `is_active`) VALUES
('Ketua Organisasi', 'Ketua Umum', 'Pimpinan', NULL, 'Motto kepemimpinan dan integritas organisasi.', 'Memimpin dan mengoordinasikan seluruh jalannya program kerja serta arah strategis organisasi.', 1, 1),
('Wakil Ketua', 'Wakil Ketua', 'Pimpinan', NULL, 'Kolaborasi aktif untuk mencapai visi bersama.', 'Mendampingi Ketua dalam mengoordinasikan bidang kerja dan kelancaran program.', 2, 1),
('Sekretaris 1', 'Sekretaris', 'Sekretariat', NULL, 'Tertib administrasi kunci tata kelola yang baik.', 'Mengelola administrasi, surat-menyurat, dan dokumentasi resmi organisasi.', 3, 1),
('Bendahara 1', 'Bendahara', 'Keuangan', NULL, 'Transparan, akuntabel, dan bertanggung jawab.', 'Mengelola pencatatan anggaran dan pembukuan keuangan organisasi secara teratur.', 4, 1),
('Koordinator Humas', 'Koordinator Divisi', 'Humas', NULL, 'Membangun sinergi dan komunikasi efektif.', 'Membangun relasi eksternal serta menjalin kemitraan strategis dengan berbagai pihak.', 5, 1),
('Koordinator Media', 'Koordinator Divisi', 'Media & Kreatif', NULL, 'Inovasi visual dan publikasi kreatif.', 'Mengelola aset publikasi visual, sosial media, dan informasi kegiatan organisasi.', 6, 1);

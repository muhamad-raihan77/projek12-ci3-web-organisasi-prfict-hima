<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Open Recruitment PR FICT 2026 | Program Representative FICT'; ?></title>
    <meta name="description" content="Daftar sebagai anggota Program Representative FICT dan jadilah bagian dari mahasiswa yang aktif, kolaboratif, dan berkontribusi untuk Horizon University Indonesia.">
    <meta name="keywords" content="PR FICT, Program Representative, FICT, Horizon University Indonesia, Open Recruitment 2026">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= isset($title) ? $title : 'Open Recruitment PR FICT 2026'; ?>">
    <meta property="og:description" content="Wadah berkontribusi dan berkembang bagi mahasiswa FICT Horizon University Indonesia.">
    <meta property="og:type" content="website">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="<?= base_url(); ?>" class="navbar-brand">
                <img src="<?= base_url('assets/img/logo.png'); ?>" alt="PR FICT Logo" class="brand-logo-img">
                <div class="brand-text">
                    <span>PR FICT</span>
                    <small>Horizon University</small>
                </div>
            </a>
            
            <ul class="navbar-nav">
                <li><a href="<?= base_url('#beranda'); ?>">Beranda</a></li>
                <li><a href="<?= base_url('#tentang'); ?>">Tentang</a></li>
                <li><a href="<?= base_url('#struktur-organisasi'); ?>">Struktur Organisasi</a></li>
                <li><a href="<?= base_url('#divisi'); ?>">Divisi</a></li>
                <li><a href="<?= base_url('program-kerja'); ?>" class="<?= (isset($active_menu) && $active_menu == 'program_kerja') ? 'active' : ''; ?>">Program Kerja</a></li>
                <li><a href="<?= base_url('pengajuan-proposal'); ?>" class="<?= (isset($active_menu) && $active_menu == 'pengajuan_proposal') ? 'active' : ''; ?>">Pengajuan Proposal</a></li>
                <li><a href="<?= base_url('#persyaratan'); ?>">Persyaratan</a></li>
                <li><a href="<?= base_url('#timeline'); ?>">Timeline</a></li>
                <li><a href="<?= base_url('#faq'); ?>">FAQ</a></li>
            </ul>
            
            <div class="navbar-actions">
                <?php if($this->session->userdata('student_logged_in')): ?>
                    <a href="<?= base_url('dashboard'); ?>" class="btn btn-outline btn-sm">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                    <a href="<?= base_url('auth/logout'); ?>" class="btn btn-primary btn-sm" style="background:#DC2626; border-color:#DC2626;">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('cek-status'); ?>" class="btn btn-outline btn-sm">Cek Status</a>
                    <a href="<?= base_url('auth/login'); ?>" class="btn btn-outline btn-sm">Login</a>
                    <a href="<?= base_url('auth/register'); ?>" class="btn btn-primary btn-sm">Daftar Akun</a>
                <?php endif; ?>
            </div>
            
            <button class="hamburger" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Admin Dashboard | PR FICT'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>const BASE_URL = '<?= base_url(); ?>';</script>
</head>
<body class="admin-body">

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <img src="<?= base_url('assets/img/logo.png'); ?>" alt="PR FICT Logo" class="sidebar-logo-img">
            <div class="title">
                PR FICT
                <small>Admin Panel</small>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="<?= (isset($active_menu) && $active_menu == 'dashboard') ? 'active' : ''; ?>">
                <a href="<?= base_url('admin/dashboard'); ?>">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
            </li>
            <li class="<?= (isset($active_menu) && $active_menu == 'applicants') ? 'active' : ''; ?>">
                <a href="<?= base_url('admin/pendaftar'); ?>">
                    <i class="fas fa-users"></i> Data Pendaftar
                </a>
            </li>
            <li class="<?= (isset($active_menu) && $active_menu == 'program_kerja') ? 'active' : ''; ?>">
                <a href="<?= base_url('admin/program-kerja'); ?>">
                    <i class="fas fa-tasks"></i> Program Kerja
                </a>
            </li>
            <li class="<?= (isset($active_menu) && $active_menu == 'pengajuan_proposal') ? 'active' : ''; ?>">
                <a href="<?= base_url('admin/pengajuan-proposal'); ?>">
                    <i class="fas fa-file-pdf"></i> Pengajuan Proposal
                </a>
            </li>
            <li class="<?= (isset($active_menu) && $active_menu == 'divisions') ? 'active' : ''; ?>">
                <a href="<?= base_url('admin/divisi'); ?>">
                    <i class="fas fa-sitemap"></i> Divisi
                </a>
            </li>
            <li class="<?= (isset($active_menu) && $active_menu == 'organization') ? 'active' : ''; ?>">
                <a href="<?= base_url('admin/organisasi'); ?>">
                    <i class="fas fa-users-cog"></i> Struktur Organisasi
                </a>
            </li>
            <li class="<?= (isset($active_menu) && $active_menu == 'export') ? 'active' : ''; ?>">
                <a href="<?= base_url('admin/export'); ?>">
                    <i class="fas fa-file-export"></i> Export Data
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="<?= base_url('admin/logout'); ?>" class="btn btn-outline-light w-100 btn-sm" style="color:rgba(255,255,255,0.8); border-color:rgba(255,255,255,0.2); width:100%;">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <header class="admin-header">
            <div style="display:flex; align-items:center;">
                <button class="mobile-toggle-btn" aria-label="Toggle Sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 style="margin:0; font-weight:700; font-size:1.1rem;"><?= isset($title) ? str_replace(' | Admin PR FICT', '', $title) : 'Dashboard'; ?></h4>
            </div>

            <div class="admin-user-info">
                <div class="avatar">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <strong style="font-size:0.88rem;"><?= html_escape($this->session->userdata('admin_name')); ?></strong>
                    <small style="display:block; color:var(--gray); font-size:0.75rem;"><?= html_escape($this->session->userdata('admin_email')); ?></small>
                </div>
            </div>
        </header>

        <main class="admin-content">

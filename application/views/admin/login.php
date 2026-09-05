<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Admin Login | PR FICT'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css'); ?>">
</head>
<body>

    <div class="admin-login-wrapper">
        <div class="admin-login-card">
            <img src="<?= base_url('assets/img/logo.png'); ?>" alt="PR FICT Logo" class="admin-login-logo">
            <h2 style="font-size:1.4rem; font-weight:800; margin-bottom:0.25rem;">ADMIN LOGIN</h2>
            <p style="color:var(--gray); font-size:0.85rem; margin-bottom:1.5rem;">Program Representative FICT</p>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-error text-start mb-3" style="font-size:0.82rem; padding:0.75rem 1rem;">
                    <i class="fas fa-exclamation-circle me-1"></i> <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <?= form_open('admin/login/process'); ?>
                <div class="form-group text-start mb-3">
                    <label style="font-size:0.82rem;">Email Admin</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@prfict.com" required value="<?= set_value('email'); ?>">
                    <?= form_error('email', '<div class="form-error">', '</div>'); ?>
                </div>

                <div class="form-group text-start mb-4">
                    <label style="font-size:0.82rem;">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    <?= form_error('password', '<div class="form-error">', '</div>'); ?>
                </div>

                <button type="submit" class="btn btn-primary w-100" style="width:100%; padding:0.75rem;">
                    <i class="fas fa-sign-in-alt me-1"></i> LOGIN DASHBOARD
                </button>
            <?= form_close(); ?>

            <div style="margin-top:1.5rem; font-size:0.78rem; color:var(--gray);">
                <a href="<?= base_url(); ?>" style="color:var(--gray); text-decoration:none;"><i class="fas fa-arrow-left me-1"></i> Kembali ke Website</a>
            </div>
        </div>
    </div>

</body>
</html>

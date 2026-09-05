<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Database Error | PR FICT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= config_item('base_url'); ?>assets/css/style.css">
</head>
<body>
    <div class="error-page">
        <div>
            <i class="fas fa-database mb-3" style="font-size: 4rem; color: var(--primary);"></i>
            <h2>Terjadi Kesalahan Database</h2>
            <p><?= $message; ?></p>
            <a href="<?= config_item('base_url'); ?>" class="btn btn-primary mt-3">
                <i class="fas fa-redo me-2"></i> Coba Lagi
            </a>
        </div>
    </div>
</body>
</html>
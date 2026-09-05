<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>404 Halaman Tidak Ditemukan | PR FICT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= config_item('base_url'); ?>assets/css/style.css">
</head>
<body>
    <div class="error-page">
        <div>
            <h1>404</h1>
            <h2>Halaman Tidak Ditemukan</h2>
            <p>Halaman yang Anda cari mungkin telah dipindahkan, dihapus, atau tidak pernah ada.</p>
            <a href="<?= config_item('base_url'); ?>" class="btn btn-primary">
                <i class="fas fa-home me-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
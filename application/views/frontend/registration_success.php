    <div class="success-page">
        <div class="container">
            <div class="success-card">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h2>Pendaftaran Berhasil!</h2>
                <p>Terima kasih telah mendaftar sebagai calon anggota Program Representative FICT 2026.</p>

                <div class="reg-code-box">
                    <div class="label">KODE PENDAFTARAN ANDA</div>
                    <div class="code"><?= html_escape($applicant->registration_code); ?></div>
                </div>

                <div class="success-warning">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    <span>Simpan atau catat kode pendaftaran di atas untuk mengecek status seleksi Anda secara berkala.</span>
                </div>

                <div class="success-buttons">
                    <a href="<?= base_url('pendaftaran/pdf/' . $applicant->registration_code); ?>" class="btn btn-primary">
                        <i class="fas fa-file-pdf me-2"></i> DOWNLOAD BUKTI PDF
                    </a>
                    <a href="<?= base_url('cek-status'); ?>" class="btn btn-outline">
                        <i class="fas fa-search me-2"></i> CEK STATUS
                    </a>
                </div>
            </div>
        </div>
    </div>

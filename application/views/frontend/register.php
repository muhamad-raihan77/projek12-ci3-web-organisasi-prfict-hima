    <div class="page-header">
        <div class="container">
            <h1>Registrasi Akun Mahasiswa FICT</h1>
            <p>Khusus Mahasiswa Fakultas Information and Computer Technology</p>
        </div>
    </div>

    <!-- Visual Flow Stepper -->
    <div style="background:#F9FAFB; border-bottom:1px solid #E5E7EB;">
        <div class="container" style="padding:1.25rem 0;">
            <div style="display:flex; align-items:center; justify-content:center; gap:0.5rem; flex-wrap:wrap; max-width:700px; margin:0 auto;">
                <!-- Step 1: Active -->
                <div style="display:flex; align-items:center; gap:0.4rem; background:var(--primary); color:#fff; padding:0.4rem 0.85rem; border-radius:50px; font-size:0.8rem; font-weight:600;">
                    <i class="fas fa-user-plus" style="font-size:0.75rem;"></i> 1. Buat Akun
                </div>
                <i class="fas fa-chevron-right" style="color:#D1D5DB; font-size:0.65rem;"></i>
                <!-- Step 2 -->
                <div style="display:flex; align-items:center; gap:0.4rem; background:#E5E7EB; color:#6B7280; padding:0.4rem 0.85rem; border-radius:50px; font-size:0.8rem; font-weight:600;">
                    <i class="fas fa-sign-in-alt" style="font-size:0.75rem;"></i> 2. Login
                </div>
                <i class="fas fa-chevron-right" style="color:#D1D5DB; font-size:0.65rem;"></i>
                <!-- Step 3 -->
                <div style="display:flex; align-items:center; gap:0.4rem; background:#E5E7EB; color:#6B7280; padding:0.4rem 0.85rem; border-radius:50px; font-size:0.8rem; font-weight:600;">
                    <i class="fas fa-id-card" style="font-size:0.75rem;"></i> 3. Biodata
                </div>
                <i class="fas fa-chevron-right" style="color:#D1D5DB; font-size:0.65rem;"></i>
                <!-- Step 4 -->
                <div style="display:flex; align-items:center; gap:0.4rem; background:#E5E7EB; color:#6B7280; padding:0.4rem 0.85rem; border-radius:50px; font-size:0.8rem; font-weight:600;">
                    <i class="fas fa-paper-plane" style="font-size:0.75rem;"></i> 4. Daftar Organisasi
                </div>
            </div>
        </div>
    </div>

    <section class="form-section" style="padding: 4rem 0;">
        <div class="container">
            <div style="max-width: 550px; margin: 0 auto;">

                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-error mb-4" style="background:#FEE2E2; color:#991B1B; padding:1rem 1.25rem; border-radius:8px; margin-bottom:1.5rem; border:1px solid #FCA5A5; display:flex; align-items:center; gap:0.75rem;">
                        <i class="fas fa-exclamation-circle" style="font-size:1.25rem;"></i>
                        <div><?= $this->session->flashdata('error'); ?></div>
                    </div>
                <?php endif; ?>

                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success mb-4" style="background:#D1FAE5; color:#065F46; padding:1rem 1.25rem; border-radius:8px; margin-bottom:1.5rem; border:1px solid #6EE7B7; display:flex; align-items:center; gap:0.75rem;">
                        <i class="fas fa-check-circle" style="font-size:1.25rem;"></i>
                        <div><?= $this->session->flashdata('success'); ?></div>
                    </div>
                <?php endif; ?>

                <div class="form-card" style="background:#fff; padding:2.5rem; border-radius:16px; border:1px solid #E5E7EB; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <div style="width:56px; height:56px; background:rgba(122,31,43,0.08); color:var(--primary); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:1.5rem; margin-bottom:1rem;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h2 style="font-size:1.5rem; font-weight:700; color:var(--text-dark); margin-bottom:0.25rem;">Buat Akun Baru</h2>
                        <p style="color:var(--gray); font-size:0.9rem;">Langkah pertama sebelum melakukan pendaftaran organisasi</p>
                    </div>

                    <form action="<?= base_url('auth/register'); ?>" method="POST" id="registerForm">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Nama Lengkap <span style="color:red">*</span></label>
                            <input type="text" name="full_name" class="form-control" value="<?= set_value('full_name'); ?>" placeholder="Masukkan nama lengkap Anda" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;">
                            <?= form_error('full_name', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;"><i class="fas fa-exclamation-circle me-1"></i>', '</div>'); ?>
                        </div>

                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Email Resmi Kampus FICT <span style="color:red">*</span></label>
                            <input type="email" name="email" id="emailInput" class="form-control" value="<?= set_value('email'); ?>" placeholder="contoh: asep.fict@krw.horizon.ac.id" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;">
                            <small style="color:var(--gray); font-size:0.8rem; display:block; margin-top:0.3rem;">
                                <i class="fas fa-info-circle me-1"></i> Wajib menggunakan email domain <strong>fict@krw.horizon.ac.id</strong>
                            </small>
                            <div id="emailJsError" style="display:none; color:#DC2626; font-size:0.825rem; margin-top:0.3rem;">
                                <i class="fas fa-exclamation-triangle me-1"></i> Pendaftaran hanya diperuntukkan bagi mahasiswa Fakultas FICT yang menggunakan email resmi kampus.
                            </div>
                            <?= form_error('email', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;"><i class="fas fa-exclamation-circle me-1"></i>', '</div>'); ?>
                        </div>

                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Password <span style="color:red">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;">
                            <?= form_error('password', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;"><i class="fas fa-exclamation-circle me-1"></i>', '</div>'); ?>
                        </div>

                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Konfirmasi Password <span style="color:red">*</span></label>
                            <input type="password" name="password_confirm" class="form-control" placeholder="Ulangi password" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;">
                            <?= form_error('password_confirm', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;"><i class="fas fa-exclamation-circle me-1"></i>', '</div>'); ?>
                        </div>

                        <button type="submit" id="btnSubmitRegister" class="btn btn-primary btn-lg" style="width:100%; margin-bottom:1.5rem;">
                            <i class="fas fa-user-check me-2"></i> Daftar Akun
                        </button>
                    </form>

                    <div style="text-align: center; border-top:1px solid #E5E7EB; padding-top:1.25rem; font-size:0.9rem; color:var(--gray);">
                        Sudah memiliki akun? <a href="<?= base_url('auth/login'); ?>" style="color:var(--primary); font-weight:600;">Login di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('emailInput');
        const emailJsError = document.getElementById('emailJsError');
        const registerForm = document.getElementById('registerForm');

        function validateEmailDomain(email) {
            email = email.trim().toLowerCase();
            return (email.endsWith('fict@krw.horizon.ac.id') || email.includes('fict@krw.horizon.ac.id'));
        }

        emailInput.addEventListener('input', function() {
            if (this.value.trim() !== '' && !validateEmailDomain(this.value)) {
                emailJsError.style.display = 'block';
                this.style.borderColor = '#DC2626';
            } else {
                emailJsError.style.display = 'none';
                this.style.borderColor = '#D1D5DB';
            }
        });

        registerForm.addEventListener('submit', function(e) {
            if (!validateEmailDomain(emailInput.value)) {
                e.preventDefault();
                emailJsError.style.display = 'block';
                emailInput.style.borderColor = '#DC2626';
                emailInput.focus();
            }
        });
    });
    </script>

    <div class="page-header">
        <div class="container">
            <h1>Login Mahasiswa FICT</h1>
            <p>Program Representative FICT — Horizon University Indonesia</p>
        </div>
    </div>

    <!-- Visual Flow Stepper -->
    <div style="background:#F9FAFB; border-bottom:1px solid #E5E7EB;">
        <div class="container" style="padding:1.25rem 0;">
            <div style="display:flex; align-items:center; justify-content:center; gap:0.5rem; flex-wrap:wrap; max-width:700px; margin:0 auto;">
                <!-- Step 1: Completed -->
                <div style="display:flex; align-items:center; gap:0.4rem; background:#D1FAE5; color:#065F46; padding:0.4rem 0.85rem; border-radius:50px; font-size:0.8rem; font-weight:600;">
                    <i class="fas fa-check-circle" style="font-size:0.75rem;"></i> 1. Buat Akun
                </div>
                <i class="fas fa-chevron-right" style="color:#D1D5DB; font-size:0.65rem;"></i>
                <!-- Step 2: Active -->
                <div style="display:flex; align-items:center; gap:0.4rem; background:var(--primary); color:#fff; padding:0.4rem 0.85rem; border-radius:50px; font-size:0.8rem; font-weight:600;">
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
            <div style="max-width: 500px; margin: 0 auto;">

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
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <h2 style="font-size:1.5rem; font-weight:700; color:var(--text-dark); margin-bottom:0.25rem;">Masuk ke Akun</h2>
                        <p style="color:var(--gray); font-size:0.9rem;">Gunakan email kampus FICT yang telah terdaftar</p>
                    </div>

                    <form action="<?= base_url('auth/login'); ?>" method="POST">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Email Kampus FICT <span style="color:red">*</span></label>
                            <input type="email" name="email" class="form-control" value="<?= set_value('email'); ?>" placeholder="contoh: asep.fict@krw.horizon.ac.id" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;">
                            <?= form_error('email', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;"><i class="fas fa-exclamation-circle me-1"></i>', '</div>'); ?>
                        </div>

                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Password <span style="color:red">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password Anda" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;">
                            <?= form_error('password', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;"><i class="fas fa-exclamation-circle me-1"></i>', '</div>'); ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg" style="width:100%; margin-bottom:1.5rem;">
                            <i class="fas fa-sign-in-alt me-2"></i> Login
                        </button>
                    </form>

                    <div style="text-align: center; border-top:1px solid #E5E7EB; padding-top:1.25rem; font-size:0.9rem; color:var(--gray);">
                        Belum memiliki akun? <a href="<?= base_url('auth/register'); ?>" style="color:var(--primary); font-weight:600;">Daftar akun di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

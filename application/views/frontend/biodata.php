    <div class="page-header">
        <div class="container">
            <h1>Lengkapi Biodata Mahasiswa</h1>
            <p>Lengkapi profil diri Anda untuk membuka akses pendaftaran organisasi FICT</p>
        </div>
    </div>

    <section class="form-section" style="padding: 4rem 0;">
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto;">

                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-error mb-4" style="background:#FEE2E2; color:#991B1B; padding:1rem 1.25rem; border-radius:8px; margin-bottom:1.5rem; border:1px solid #FCA5A5; display:flex; align-items:center; gap:0.75rem;">
                        <i class="fas fa-exclamation-circle" style="font-size:1.25rem;"></i>
                        <div><?= $this->session->flashdata('error'); ?></div>
                    </div>
                <?php endif; ?>

                <?php if(isset($upload_error)): ?>
                    <div class="alert alert-error mb-4" style="background:#FEE2E2; color:#991B1B; padding:1rem 1.25rem; border-radius:8px; margin-bottom:1.5rem; border:1px solid #FCA5A5; display:flex; align-items:center; gap:0.75rem;">
                        <i class="fas fa-exclamation-triangle" style="font-size:1.25rem;"></i>
                        <div><?= $upload_error; ?></div>
                    </div>
                <?php endif; ?>

                <div class="form-card" style="background:#fff; padding:2.5rem; border-radius:16px; border:1px solid #E5E7EB; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
                    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #E5E7EB; padding-bottom:1.25rem; margin-bottom:2rem;">
                        <div>
                            <h2 style="font-size:1.4rem; font-weight:700; color:var(--text-dark); margin:0;">Formulir Biodata Diri</h2>
                            <p style="color:var(--gray); font-size:0.875rem; margin-top:0.25rem;">Semua field bertanda (<span style="color:red">*</span>) wajib diisi</p>
                        </div>
                        <a href="<?= base_url('dashboard'); ?>" class="btn btn-outline btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                        </a>
                    </div>

                    <?= form_open_multipart('user/biodata'); ?>
                        
                        <!-- Foto Profil -->
                        <div style="background:#F9FAFB; padding:1.5rem; border-radius:12px; border:1px solid #F3F4F6; margin-bottom:2rem; display:flex; gap:1.5rem; align-items:center;">
                            <div style="width:100px; height:100px; border-radius:50%; background:#E5E7EB; overflow:hidden; display:flex; align-items:center; justify-content:center; flex-shrink:0; border:3px solid var(--primary-light);">
                                <?php if(!empty($user->photo) && file_exists('./uploads/photos/' . $user->photo)): ?>
                                    <img src="<?= base_url('uploads/photos/' . $user->photo); ?>" alt="Foto Profil" style="width:100%; height:100%; object-fit:cover;">
                                <?php else: ?>
                                    <i class="fas fa-user" style="font-size:2.5rem; color:#9CA3AF;"></i>
                                <?php endif; ?>
                            </div>
                            <div style="flex-grow:1;">
                                <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Foto Profil Resmi <span style="color:red">*</span></label>
                                <input type="file" name="photo" accept="image/png, image/jpeg, image/jpg" style="font-size:0.875rem;">
                                <small style="color:var(--gray); font-size:0.8rem; display:block; margin-top:0.35rem;">
                                    <i class="fas fa-info-circle me-1"></i> Format: JPG/PNG, Maksimal 2MB. Pas foto rapi & jelas.
                                </small>
                            </div>
                        </div>

                        <!-- Grid 2 kolom Data Diri -->
                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.25rem; margin-bottom:1.25rem;">
                            <div class="form-group">
                                <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Nama Lengkap <span style="color:red">*</span></label>
                                <input type="text" name="full_name" class="form-control" value="<?= set_value('full_name', $user->full_name); ?>" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;">
                                <?= form_error('full_name', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;">', '</div>'); ?>
                            </div>

                            <div class="form-group">
                                <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">NIM <span style="color:red">*</span></label>
                                <input type="text" name="nim" class="form-control" value="<?= set_value('nim', $user->nim); ?>" placeholder="Contoh: 21102001" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;">
                                <?= form_error('nim', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;">', '</div>'); ?>
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.25rem; margin-bottom:1.25rem;">
                            <div class="form-group">
                                <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Tempat Lahir <span style="color:red">*</span></label>
                                <input type="text" name="birth_place" class="form-control" value="<?= set_value('birth_place', $user->birth_place); ?>" placeholder="Contoh: Karawang" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;">
                                <?= form_error('birth_place', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;">', '</div>'); ?>
                            </div>

                            <div class="form-group">
                                <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Tanggal Lahir <span style="color:red">*</span></label>
                                <input type="date" name="birth_date" class="form-control" value="<?= set_value('birth_date', $user->birth_date); ?>" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;">
                                <?= form_error('birth_date', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;">', '</div>'); ?>
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.25rem; margin-bottom:1.25rem;">
                            <div class="form-group">
                                <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Jenis Kelamin <span style="color:red">*</span></label>
                                <select name="gender" class="form-control" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" <?= set_select('gender', 'Laki-laki', $user->gender == 'Laki-laki'); ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= set_select('gender', 'Perempuan', $user->gender == 'Perempuan'); ?>>Perempuan</option>
                                </select>
                                <?= form_error('gender', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;">', '</div>'); ?>
                            </div>

                            <div class="form-group">
                                <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Nomor HP / WhatsApp <span style="color:red">*</span></label>
                                <input type="text" name="phone" class="form-control" value="<?= set_value('phone', $user->phone); ?>" placeholder="Contoh: 08123456789" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;">
                                <?= form_error('phone', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;">', '</div>'); ?>
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.25rem; margin-bottom:1.25rem;">
                            <div class="form-group">
                                <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Program Studi <span style="color:red">*</span></label>
                                <select name="study_program" class="form-control" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;">
                                    <option value="">-- Pilih Program Studi --</option>
                                    <option value="Informatika" <?= set_select('study_program', 'Informatika', $user->study_program == 'Informatika'); ?>>Informatika</option>
                                    <option value="Sistem Informasi" <?= set_select('study_program', 'Sistem Informasi', $user->study_program == 'Sistem Informasi'); ?>>Sistem Informasi</option>
                                    <option value="Teknologi Informasi" <?= set_select('study_program', 'Teknologi Informasi', $user->study_program == 'Teknologi Informasi'); ?>>Teknologi Informasi</option>
                                </select>
                                <?= form_error('study_program', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;">', '</div>'); ?>
                            </div>

                            <div class="form-group">
                                <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Kelas <span style="color:red">*</span></label>
                                <input type="text" name="class_name" class="form-control" value="<?= set_value('class_name', $user->class_name); ?>" placeholder="Contoh: IF21A / SI22B" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;">
                                <?= form_error('class_name', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;">', '</div>'); ?>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom:1.25rem;">
                            <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Alamat Lengkap <span style="color:red">*</span></label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat tempat tinggal Anda saat ini" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;"><?= set_value('address', $user->address); ?></textarea>
                            <?= form_error('address', '<div style="color:#DC2626; font-size:0.825rem; margin-top:0.3rem;">', '</div>'); ?>
                        </div>

                        <div class="form-group" style="margin-bottom:1.25rem;">
                            <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Pengalaman Organisasi <span style="color:gray; font-weight:normal;">(Opsional)</span></label>
                            <textarea name="organization_experience" class="form-control" rows="3" placeholder="Sebutkan nama organisasi, posisi, dan periode (jika ada)" style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;"><?= set_value('organization_experience', $user->organization_experience); ?></textarea>
                        </div>

                        <div class="form-group" style="margin-bottom:2rem;">
                            <label style="display:block; font-weight:600; font-size:0.9rem; margin-bottom:0.4rem;">Prestasi / Keahlian <span style="color:gray; font-weight:normal;">(Opsional)</span></label>
                            <textarea name="achievements" class="form-control" rows="3" placeholder="Sebutkan prestasi atau keahlian utama yang Anda miliki (jika ada)" style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-size:0.95rem;"><?= set_value('achievements', $user->achievements); ?></textarea>
                        </div>

                        <div style="display:flex; gap:1rem;">
                            <button type="submit" class="btn btn-primary btn-lg" style="flex-grow:1;">
                                <i class="fas fa-save me-2"></i> Simpan Biodata
                            </button>
                            <a href="<?= base_url('dashboard'); ?>" class="btn btn-outline btn-lg">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

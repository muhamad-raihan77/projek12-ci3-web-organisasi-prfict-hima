    <div class="page-header">
        <div class="container">
            <h1>Formulir Pendaftaran Anggota</h1>
            <p>Program Representative FICT — Open Recruitment 2026</p>
        </div>
    </div>

    <section class="form-section">
        <div class="container">
            <!-- Progress Indicator -->
            <div class="progress-steps">
                <div class="progress-step active" id="pStep0">
                    <div class="step-number">01</div>
                    <div class="step-label">Data Diri (Terverifikasi)</div>
                </div>
                <div class="progress-step" id="pStep1">
                    <div class="step-number">02</div>
                    <div class="step-label">Pilihan Divisi</div>
                </div>
                <div class="progress-step" id="pStep2">
                    <div class="step-number">03</div>
                    <div class="step-label">Persetujuan</div>
                </div>
            </div>

            <?php if(isset($upload_error)): ?>
                <div class="alert alert-error max-w-700 mx-auto" style="max-width:700px; margin:0 auto 1.5rem;">
                    <i class="fas fa-exclamation-triangle"></i> <?= $upload_error; ?>
                </div>
            <?php endif; ?>

            <div class="form-card">
                <?= form_open_multipart('pendaftaran/submit', ['id' => 'registrationForm']); ?>
                
                <!-- STEP 1: DATA PRIBADI (Terisi Otomatis dari Akun) -->
                <div class="form-step active" data-step="0">
                    <h3>01. Data Diri & Akun FICT</h3>
                    <p class="step-desc">Data diri terisi otomatis dari biodata akun terverifikasi Anda.</p>
                    
                    <div style="background:#FAF8F8; padding:1.25rem 1.5rem; border-radius:12px; border:1px solid #E5E7EB; margin-bottom:1.5rem; display:flex; gap:1.25rem; align-items:center;">
                        <div style="width:70px; height:70px; border-radius:50%; overflow:hidden; border:2px solid var(--primary); flex-shrink:0;">
                            <?php if(!empty($user->photo) && file_exists('./uploads/photos/' . $user->photo)): ?>
                                <img src="<?= base_url('uploads/photos/' . $user->photo); ?>" style="width:100%; height:100%; object-fit:cover;">
                            <?php else: ?>
                                <i class="fas fa-user-circle" style="font-size:4rem; color:#9CA3AF;"></i>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h4 style="font-size:1.1rem; font-weight:700; color:var(--text-dark); margin:0;"><?= htmlspecialchars($user->full_name); ?></h4>
                            <p style="font-size:0.875rem; color:var(--gray); margin:0.15rem 0;">
                                NIM: <strong><?= htmlspecialchars($user->nim); ?></strong> | Prodi: <strong><?= htmlspecialchars($user->study_program); ?></strong> (<?= htmlspecialchars($user->class_name); ?>)
                            </p>
                            <small style="color:var(--primary); font-weight:600;">
                                <i class="fas fa-envelope me-1"></i> <?= htmlspecialchars($user->email); ?>
                            </small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Semester Saat Ini <span class="required">*</span></label>
                            <select name="semester" class="form-control" required>
                                <option value="">-- Pilih Semester --</option>
                                <?php for($i=1; $i<=8; $i++): ?>
                                    <option value="<?= $i; ?>" <?= set_select('semester', $i); ?>>Semester <?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <?= form_error('semester', '<div class="form-error">', '</div>'); ?>
                        </div>

                        <div class="form-group">
                            <label>Nomor WhatsApp <span class="required">*</span></label>
                            <input type="tel" class="form-control" value="<?= htmlspecialchars($user->phone); ?>" readonly style="background:#F3F4F6; cursor:not-allowed;">
                            <small class="form-help">Dapat diperbarui melalui menu Edit Biodata.</small>
                        </div>
                    </div>

                    <div class="form-buttons">
                        <div></div>
                        <button type="button" class="btn btn-primary btn-next">
                            Lanjut <i class="fas fa-arrow-right me-1"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 2: DATA PENDAFTARAN -->
                <div class="form-step" data-step="1">
                    <h3>02. Data Pendaftaran Organisasi</h3>
                    <p class="step-desc">Tentukan pilihan divisi dan jelaskan motivasi Anda bergabung.</p>

                    <div class="form-group">
                        <label>Pilihan Divisi <span class="required">*</span></label>
                        <select name="division_id" class="form-control" required>
                            <option value="">-- Pilih Divisi --</option>
                            <?php if(!empty($divisions)): ?>
                                <?php foreach($divisions as $div): ?>
                                    <option value="<?= $div->id; ?>" <?= set_select('division_id', $div->id); ?>>
                                        <?= html_escape($div->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?= form_error('division_id', '<div class="form-error">', '</div>'); ?>
                    </div>

                    <div class="form-group">
                        <label>Alasan Bergabung <span class="required">*</span></label>
                        <textarea name="reason" class="form-control" rows="4" placeholder="Jelaskan alasan dan motivasi Anda ingin menjadi bagian dari PR FICT..." required><?= set_value('reason'); ?></textarea>
                        <?= form_error('reason', '<div class="form-error">', '</div>'); ?>
                    </div>

                    <div class="form-group">
                        <label>Keahlian / Skill Spesifik (Opsional)</label>
                        <input type="text" name="skills" class="form-control" value="<?= set_value('skills', $user->achievements); ?>" placeholder="Contoh: Desain Grafis, Public Speaking, Video Editing, Coding">
                    </div>

                    <div class="form-buttons">
                        <button type="button" class="btn btn-outline btn-prev">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </button>
                        <button type="button" class="btn btn-primary btn-next">
                            Lanjut <i class="fas fa-arrow-right me-1"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 3: DOKUMEN & PERSETUJUAN -->
                <div class="form-step" data-step="2">
                    <h3>03. Dokumen & Persetujuan</h3>
                    <p class="step-desc">Upload berkas CV (opsional) dan konfirmasi pendaftaran.</p>

                    <div class="form-group">
                        <label>Upload Curriculum Vitae (CV) (PDF, Max 5MB, Opsional)</label>
                        <div class="file-upload">
                            <i class="fas fa-file-pdf"></i>
                            <p>Klik atau drag file CV di sini</p>
                            <div class="file-name"></div>
                            <input type="file" name="cv" accept="application/pdf">
                        </div>
                    </div>

                    <div class="checkbox-group" style="margin-top:1.5rem;">
                        <input type="checkbox" name="agreement" id="agreement" value="1" required>
                        <label for="agreement">Saya menyatakan bahwa seluruh data yang saya masukkan adalah benar dan siap mengikuti alur seleksi yang berlaku.</label>
                    </div>
                    <?= form_error('agreement', '<div class="form-error mb-3">', '</div>'); ?>

                    <div class="form-buttons">
                        <button type="button" class="btn btn-outline btn-prev">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </button>
                        <button type="button" class="btn btn-primary" id="submitRegBtn">
                            <i class="fas fa-paper-plane me-1"></i> Kirim Pendaftaran
                        </button>
                    </div>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </section>

    <!-- Confirmation Modal -->
    <div class="modal-overlay" id="confirmModal">
        <div class="modal-box">
            <i class="fas fa-question-circle" style="font-size:3rem; color:var(--primary); margin-bottom:1rem;"></i>
            <h3>Konfirmasi Pendaftaran</h3>
            <p>Apakah Anda yakin data yang dimasukkan sudah benar? Data yang sudah dikirim tidak dapat diubah kembali.</p>
            <div class="modal-buttons">
                <button type="button" class="btn btn-outline" id="modalCancelSubmit">Kembali</button>
                <button type="button" class="btn btn-primary" id="modalConfirmSubmit">Ya, Kirim Data</button>
            </div>
        </div>
    </div>

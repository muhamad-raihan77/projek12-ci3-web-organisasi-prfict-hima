<!-- Flash Messages -->
<?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success mb-4">
        <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-error mb-4">
        <i class="fas fa-exclamation-triangle"></i> <?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<div style="margin-bottom:1.5rem;">
    <a href="<?= base_url('admin/pendaftar'); ?>" class="btn btn-outline btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<div class="admin-grid-2-1">
    <!-- Main Detail Card -->
    <div style="background:var(--white); padding:2rem; border-radius:var(--radius); border:1px solid var(--gray-light); box-shadow:0 1px 3px rgba(0,0,0,0.05);">
        
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:2rem; border-bottom:1px solid var(--gray-light); padding-bottom:1.5rem;">
            <div>
                <h2 style="font-size:1.5rem; font-weight:800; margin-bottom:0.25rem;"><?= html_escape($applicant->full_name); ?></h2>
                <p style="color:var(--gray); margin:0; font-size:0.9rem;">
                    <strong><?= html_escape($applicant->registration_code); ?></strong> • <?= html_escape($applicant->study_program); ?> (Semester <?= html_escape($applicant->semester); ?>)
                </p>
            </div>
            
            <?php 
                $badge_class = 'menunggu';
                if ($applicant->status == 'Seleksi Administrasi') $badge_class = 'seleksi';
                elseif ($applicant->status == 'Interview') $badge_class = 'interview';
                elseif ($applicant->status == 'Lolos') $badge_class = 'lolos';
                elseif ($applicant->status == 'Tidak Lolos') $badge_class = 'tidak-lolos';
            ?>
            <span class="status-badge <?= $badge_class; ?>" style="font-size:0.85rem; padding:0.5rem 1.25rem;">
                <?= strtoupper(html_escape($applicant->status)); ?>
            </span>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.25rem; margin-bottom:2rem;">
            <div>
                <small style="color:var(--gray); font-size:0.75rem; display:block; margin-bottom:0.25rem;">NIM</small>
                <strong><?= html_escape($applicant->nim); ?></strong>
            </div>
            <div>
                <small style="color:var(--gray); font-size:0.75rem; display:block; margin-bottom:0.25rem;">JENIS KELAMIN</small>
                <strong><?= html_escape($applicant->gender); ?></strong>
            </div>
            <div>
                <small style="color:var(--gray); font-size:0.75rem; display:block; margin-bottom:0.25rem;">EMAIL</small>
                <strong><?= html_escape($applicant->email); ?></strong>
            </div>
            <div>
                <small style="color:var(--gray); font-size:0.75rem; display:block; margin-bottom:0.25rem;">WHATSAPP</small>
                <strong><?= html_escape($applicant->whatsapp); ?></strong>
            </div>
            <div>
                <small style="color:var(--gray); font-size:0.75rem; display:block; margin-bottom:0.25rem;">PILIHAN DIVISI</small>
                <strong style="color:var(--primary);"><?= html_escape($applicant->division_name); ?></strong>
            </div>
            <div>
                <small style="color:var(--gray); font-size:0.75rem; display:block; margin-bottom:0.25rem;">TANGGAL DAFTAR</small>
                <strong><?= date('d F Y H:i', strtotime($applicant->created_at)); ?></strong>
            </div>
        </div>

        <div style="margin-bottom:1.5rem;">
            <h4 style="font-size:0.95rem; font-weight:700; color:var(--text-dark); margin-bottom:0.5rem;">Alasan Bergabung</h4>
            <p style="background:var(--off-white); padding:1rem; border-radius:8px; font-size:0.9rem; line-height:1.6; color:var(--text-body); white-space:pre-line;"><?= html_escape($applicant->reason); ?></p>
        </div>

        <div style="margin-bottom:1.5rem;">
            <h4 style="font-size:0.95rem; font-weight:700; color:var(--text-dark); margin-bottom:0.5rem;">Pengalaman Organisasi</h4>
            <p style="background:var(--off-white); padding:1rem; border-radius:8px; font-size:0.9rem; line-height:1.6; color:var(--text-body); white-space:pre-line;"><?= !empty($applicant->organization_experience) ? html_escape($applicant->organization_experience) : '-'; ?></p>
        </div>

        <div style="margin-bottom:1.5rem;">
            <h4 style="font-size:0.95rem; font-weight:700; color:var(--text-dark); margin-bottom:0.5rem;">Keahlian / Skill</h4>
            <p style="background:var(--off-white); padding:1rem; border-radius:8px; font-size:0.9rem; color:var(--text-body);"><?= !empty($applicant->skills) ? html_escape($applicant->skills) : '-'; ?></p>
        </div>

        <!-- Files Section -->
        <div style="border-top:1px solid var(--gray-light); padding-top:1.5rem; margin-top:2rem;">
            <h4 style="font-size:0.95rem; font-weight:700; color:var(--text-dark); margin-bottom:1rem;">Dokumen Upload</h4>
            <div style="display:flex; gap:1rem; flex-wrap:wrap;">
                <?php if($applicant->photo): ?>
                    <a href="<?= base_url('uploads/photos/' . $applicant->photo); ?>" target="_blank" class="btn btn-outline btn-sm">
                        <i class="fas fa-image me-1"></i> Lihat Foto
                    </a>
                <?php else: ?>
                    <span style="color:var(--gray); font-size:0.85rem;">Foto: Tidak diupload</span>
                <?php endif; ?>

                <?php if($applicant->cv): ?>
                    <a href="<?= base_url('uploads/cv/' . $applicant->cv); ?>" target="_blank" class="btn btn-outline btn-sm">
                        <i class="fas fa-file-pdf me-1"></i> Lihat CV
                    </a>
                <?php else: ?>
                    <span style="color:var(--gray); font-size:0.85rem;">CV: Tidak diupload</span>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- Actions Sidebar -->
    <div>
        <!-- Update Status Card -->
        <div style="background:var(--white); padding:1.5rem; border-radius:var(--radius); border:1px solid var(--gray-light); box-shadow:0 1px 3px rgba(0,0,0,0.05); margin-bottom:1.5rem;">
            <h3 style="font-size:1rem; font-weight:700; margin-bottom:1rem;">Ubah Status Seleksi</h3>
            
            <?= form_open('admin/pendaftar/update-status'); ?>
                <input type="hidden" name="applicant_id" value="<?= $applicant->id; ?>">
                
                <div class="form-group mb-3">
                    <select name="status" class="form-control" style="font-size:0.9rem;">
                        <?php foreach(['Menunggu', 'Seleksi Administrasi', 'Interview', 'Lolos', 'Tidak Lolos'] as $s): ?>
                            <option value="<?= $s; ?>" <?= ($applicant->status == $s) ? 'selected' : ''; ?>><?= $s; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100" style="width:100%;">
                    <i class="fas fa-save me-1"></i> Simpan Status
                </button>
            <?= form_close(); ?>
        </div>

        <!-- Quick Actions Card -->
        <div style="background:var(--white); padding:1.5rem; border-radius:var(--radius); border:1px solid var(--gray-light); box-shadow:0 1px 3px rgba(0,0,0,0.05);">
            <h3 style="font-size:1rem; font-weight:700; margin-bottom:1rem;">Aksi Lainnya</h3>
            
            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                <a href="<?= base_url('admin/pendaftar/pdf/' . $applicant->id); ?>" class="btn btn-info w-100" style="width:100%;" target="_blank">
                    <i class="fas fa-file-pdf me-1"></i> Download Bukti PDF
                </a>

                <a href="<?= base_url('admin/pendaftar/delete/' . $applicant->id); ?>" class="btn btn-danger w-100 btn-delete-confirm" style="width:100%;">
                    <i class="fas fa-trash me-1"></i> Hapus Pendaftar
                </a>
            </div>
        </div>
    </div>
</div>

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

<div class="admin-grid-2-1">
    <!-- Members List Table -->
    <div class="card-table">
        <div class="card-table-header">
            <h3><i class="fas fa-users-cog me-2"></i>Anggota Organisasi</h3>
            <span style="font-size:0.82rem; color:var(--gray);"><?= count($members); ?> anggota</span>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Urutan</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Divisi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($members)): ?>
                        <?php foreach($members as $m): ?>
                            <tr>
                                <td style="text-align:center; font-weight:600; color:var(--gray);"><?= $m->display_order; ?></td>
                                <td>
                                    <?php 
                                    $m_photo_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'organization' . DIRECTORY_SEPARATOR . $m->photo;
                                    $m_photo_path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $m_photo_path);
                                    if($m->photo && file_exists($m_photo_path)): ?>
                                        <img src="<?= base_url('uploads/organization/' . $m->photo); ?>" alt="<?= html_escape($m->name); ?>" style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:2px solid var(--primary);">
                                    <?php else: ?>
                                        <div style="width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg, var(--primary), var(--primary-light)); color:white; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.75rem;">
                                            <?= strtoupper(substr($m->name, 0, 1) . (strpos($m->name, ' ') !== false ? substr($m->name, strpos($m->name, ' ')+1, 1) : '')); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= html_escape($m->name); ?></strong></td>
                                <td><?= html_escape($m->position); ?></td>
                                <td style="font-size:0.82rem; color:var(--gray);"><?= html_escape($m->division); ?></td>
                                <td>
                                    <?php if($m->is_active): ?>
                                        <span class="status-badge lolos">Aktif</span>
                                    <?php else: ?>
                                        <span class="status-badge tidak-lolos">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="display:flex; gap:0.35rem;">
                                        <button type="button" class="btn btn-primary btn-sm btn-edit-org"
                                                title="Edit"
                                                data-id="<?= $m->id; ?>"
                                                data-name="<?= html_escape($m->name); ?>"
                                                data-position="<?= html_escape($m->position); ?>"
                                                data-division="<?= html_escape($m->division); ?>"
                                                data-motto="<?= html_escape($m->motto ?? ''); ?>"
                                                data-description="<?= html_escape($m->description ?? ''); ?>"
                                                data-instagram="<?= html_escape($m->social_instagram ?? ''); ?>"
                                                data-linkedin="<?= html_escape($m->social_linkedin ?? ''); ?>"
                                                data-order="<?= $m->display_order; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="<?= base_url('admin/organisasi/toggle/' . $m->id); ?>" class="btn btn-warning btn-sm" title="Toggle Aktif/Nonaktif">
                                            <i class="fas fa-power-off"></i>
                                        </a>
                                        <a href="<?= base_url('admin/organisasi/delete/' . $m->id); ?>" class="btn btn-danger btn-sm btn-delete-confirm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align:center; color:var(--gray); padding:2rem;">Belum ada anggota organisasi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add New Member Card -->
    <div style="background:var(--white); padding:1.5rem; border-radius:var(--radius); border:1px solid var(--gray-light); box-shadow:0 1px 3px rgba(0,0,0,0.05); height:fit-content;">
        <h3 style="font-size:1rem; font-weight:700; margin-bottom:1rem;"><i class="fas fa-user-plus me-1"></i> Tambah Anggota</h3>
        
        <?= form_open_multipart('admin/organisasi/tambah'); ?>
            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: M. Raihan" required>
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Jabatan <span class="required">*</span></label>
                <input type="text" name="position" class="form-control" placeholder="Contoh: Ketua" required>
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Divisi <span class="required">*</span></label>
                <input type="text" name="division" class="form-control" placeholder="Contoh: Pimpinan" required>
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Moto</label>
                <input type="text" name="motto" class="form-control" placeholder="Moto atau quote (opsional)">
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Deskripsi</label>
                <textarea name="description" class="form-control" placeholder="Deskripsi tugas/peran..." style="min-height:70px;"></textarea>
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Foto Profil</label>
                <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                <small style="font-size:0.72rem; color:var(--gray); display:block; margin-top:0.25rem;">Format: JPG, JPEG, PNG, WEBP. Maks: 2MB</small>
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Instagram</label>
                <input type="text" name="social_instagram" class="form-control" placeholder="@username">
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">LinkedIn</label>
                <input type="text" name="social_linkedin" class="form-control" placeholder="URL profil LinkedIn">
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Urutan Tampil</label>
                <input type="number" name="display_order" class="form-control" placeholder="Otomatis jika kosong" min="1">
            </div>

            <button type="submit" class="btn btn-primary w-100" style="width:100%;">
                <i class="fas fa-plus me-1"></i> Tambah Anggota
            </button>
        <?= form_close(); ?>
    </div>
</div>

<!-- Edit Member Modal -->
<div class="admin-modal-overlay" id="editOrgModal">
    <div class="admin-modal">
        <div class="admin-modal-header">
            <h3><i class="fas fa-user-edit me-2"></i>Edit Anggota</h3>
            <button class="admin-modal-close" onclick="closeEditOrgModal()" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?= form_open_multipart('', ['id' => 'editOrgForm']); ?>
        <div class="admin-modal-body">
            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="name" id="editOrgName" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Jabatan <span class="required">*</span></label>
                <input type="text" name="position" id="editOrgPosition" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Divisi <span class="required">*</span></label>
                <input type="text" name="division" id="editOrgDivision" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Moto</label>
                <input type="text" name="motto" id="editOrgMotto" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Deskripsi</label>
                <textarea name="description" id="editOrgDescription" class="form-control" style="min-height:70px;"></textarea>
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Ganti Foto Profil</label>
                <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                <small style="font-size:0.72rem; color:var(--gray); display:block; margin-top:0.25rem;">Kosongkan jika tidak ingin mengganti foto.</small>
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Instagram</label>
                <input type="text" name="social_instagram" id="editOrgInstagram" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">LinkedIn</label>
                <input type="text" name="social_linkedin" id="editOrgLinkedin" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Urutan Tampil</label>
                <input type="number" name="display_order" id="editOrgOrder" class="form-control" min="1">
            </div>
        </div>
        <div class="admin-modal-footer">
            <button type="button" class="btn btn-outline btn-sm" onclick="closeEditOrgModal()">Batal</button>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-save me-1"></i> Simpan Perubahan
            </button>
        </div>
        <?= form_close(); ?>
    </div>
</div>

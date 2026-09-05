<!-- Flash Messages -->
<?php if($this->session->flashdata('success')): ?>
    <div style="background:#D1FAE5; color:#065F46; padding:0.85rem 1.25rem; border-radius:8px; border:1px solid #A7F3D0; margin-bottom:1.5rem; font-weight:500;">
        <i class="fas fa-check-circle me-1"></i> <?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
    <div style="background:#FEE2E2; color:#991B1B; padding:0.85rem 1.25rem; border-radius:8px; border:1px solid #FECACA; margin-bottom:1.5rem; font-weight:500;">
        <i class="fas fa-exclamation-circle me-1"></i> <?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<!-- Header & Add Button -->
<div class="card-table">
    <div class="card-table-header">
        <div>
            <h3 style="font-size:1.1rem; font-weight:700;">Kelola Program Kerja</h3>
            <small style="color:var(--gray);">Kelola daftar program kerja, status, dan foto dokumentasi</small>
        </div>
        <button class="btn btn-primary btn-sm" onclick="openAddModal()">
            <i class="fas fa-plus me-1"></i> Tambah Program Kerja
        </button>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:40px; text-align:center;">No</th>
                    <th>Nama Program</th>
                    <th>Divisi</th>
                    <th>Activity</th>
                    <th>Target</th>
                    <th>PIC</th>
                    <th>Status</th>
                    <th>Dokumentasi</th>
                    <th style="width:160px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($programs)): ?>
                    <?php $no = 1; foreach ($programs as $p): ?>
                        <tr>
                            <td style="text-align:center; font-weight:600;"><?= $no++; ?></td>
                            <td><strong><?= html_escape($p->nama_program); ?></strong></td>
                            <td><?= html_escape($p->divisi); ?></td>
                            <td style="max-width:180px; font-size:0.85rem;"><?= !empty($p->activity) ? nl2br(html_escape($p->activity)) : '-'; ?></td>
                            <td style="max-width:180px; font-size:0.85rem;"><?= !empty($p->target) ? nl2br(html_escape($p->target)) : '-'; ?></td>
                            <td><strong><?= html_escape($p->pic); ?></strong></td>
                            <td>
                                <form action="<?= base_url('admin/program-kerja/update-status/' . $p->id); ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                    <select name="status" onchange="this.form.submit()" class="form-control" style="padding:0.25rem 0.5rem; font-size:0.8rem; border-radius:4px; font-weight:600;">
                                        <option value="Belum Dimulai" <?= $p->status == 'Belum Dimulai' ? 'selected' : ''; ?>>Belum Dimulai</option>
                                        <option value="Berjalan" <?= $p->status == 'Berjalan' ? 'selected' : ''; ?>>Berjalan</option>
                                        <option value="Selesai" <?= $p->status == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <div class="admin-doc-grid">
                                    <?php if (!empty($p->dokumentasi)): ?>
                                        <?php foreach ($p->dokumentasi as $doc): ?>
                                            <div class="admin-doc-item" title="<?= html_escape($doc->caption); ?>">
                                                <img src="<?= base_url('uploads/program_dokumentasi/' . $doc->file_name); ?>" alt="Dokumentasi">
                                                <a href="<?= base_url('admin/program-kerja/delete-dokumentasi/' . $doc->id); ?>" class="btn-del-doc btn-delete-confirm" title="Hapus foto">&times;</a>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <small style="color:var(--gray); font-style:italic;">Belum ada foto</small>
                                    <?php endif; ?>
                                </div>

                                <button class="btn btn-outline btn-sm" style="margin-top:0.5rem; padding:0.25rem 0.5rem; font-size:0.75rem;" onclick="openUploadModal(<?= $p->id; ?>, '<?= html_escape(addslashes($p->nama_program)); ?>')">
                                    <i class="fas fa-upload me-1"></i> Upload Foto
                                </button>
                            </td>
                            <td style="text-align:center;">
                                <button class="btn btn-outline btn-sm" style="padding:0.25rem 0.5rem; font-size:0.8rem;" 
                                        onclick="openEditModal(<?= $p->id; ?>, '<?= html_escape(addslashes($p->nama_program)); ?>', '<?= html_escape(addslashes($p->divisi)); ?>', '<?= html_escape(addslashes($p->activity)); ?>', '<?= html_escape(addslashes($p->target)); ?>', '<?= html_escape(addslashes($p->pic)); ?>', '<?= html_escape($p->status); ?>')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="<?= base_url('admin/program-kerja/delete/' . $p->id); ?>" class="btn btn-danger btn-sm btn-delete-confirm" style="padding:0.25rem 0.5rem; font-size:0.8rem;">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align:center; padding:2rem; color:var(--gray);">Belum ada program kerja.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Program Kerja -->
<div id="addProkerModal" class="admin-modal-overlay">
    <div class="admin-modal">
        <div class="admin-modal-header">
            <h3><i class="fas fa-plus-circle me-1"></i> Tambah Program Kerja</h3>
            <button class="admin-modal-close" onclick="closeAddModal()">&times;</button>
        </div>
        <form action="<?= base_url('admin/program-kerja/add'); ?>" method="POST">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <div class="admin-modal-body">
                <div style="margin-bottom:1rem;">
                    <label style="font-weight:600; font-size:0.88rem;">Nama Program <span style="color:red;">*</span></label>
                    <input type="text" name="nama_program" class="form-control" required style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #ccc;">
                </div>
                <div style="margin-bottom:1rem;">
                    <label style="font-weight:600; font-size:0.88rem;">Divisi <span style="color:red;">*</span></label>
                    <select name="divisi" class="form-control" required style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #ccc;">
                        <option value="">-- Pilih Divisi --</option>
                        <?php if(!empty($divisions)): ?>
                            <?php foreach($divisions as $d): ?>
                                <option value="<?= html_escape($d->name); ?>"><?= html_escape($d->name); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div style="margin-bottom:1rem;">
                    <label style="font-weight:600; font-size:0.88rem;">Activity</label>
                    <textarea name="activity" rows="2" class="form-control" style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #ccc;"></textarea>
                </div>
                <div style="margin-bottom:1rem;">
                    <label style="font-weight:600; font-size:0.88rem;">Target</label>
                    <textarea name="target" rows="2" class="form-control" style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #ccc;"></textarea>
                </div>
                <div style="margin-bottom:1rem;">
                    <label style="font-weight:600; font-size:0.88rem;">PIC <span style="color:red;">*</span></label>
                    <input type="text" name="pic" class="form-control" required style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #ccc;">
                </div>
                <div style="margin-bottom:1rem;">
                    <label style="font-weight:600; font-size:0.88rem;">Status</label>
                    <select name="status" class="form-control" style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #ccc;">
                        <option value="Belum Dimulai">Belum Dimulai</option>
                        <option value="Berjalan">Berjalan</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
            </div>
            <div class="admin-modal-footer">
                <button type="button" class="btn btn-outline btn-sm" onclick="closeAddModal()">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Program Kerja -->
<div id="editProkerModal" class="admin-modal-overlay">
    <div class="admin-modal">
        <div class="admin-modal-header">
            <h3><i class="fas fa-edit me-1"></i> Edit Program Kerja</h3>
            <button class="admin-modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editProkerForm" action="" method="POST">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <div class="admin-modal-body">
                <div style="margin-bottom:1rem;">
                    <label style="font-weight:600; font-size:0.88rem;">Nama Program <span style="color:red;">*</span></label>
                    <input type="text" id="edit_nama_program" name="nama_program" class="form-control" required style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #ccc;">
                </div>
                <div style="margin-bottom:1rem;">
                    <label style="font-weight:600; font-size:0.88rem;">Divisi <span style="color:red;">*</span></label>
                    <select id="edit_divisi" name="divisi" class="form-control" required style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #ccc;">
                        <option value="">-- Pilih Divisi --</option>
                        <?php if(!empty($divisions)): ?>
                            <?php foreach($divisions as $d): ?>
                                <option value="<?= html_escape($d->name); ?>"><?= html_escape($d->name); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div style="margin-bottom:1rem;">
                    <label style="font-weight:600; font-size:0.88rem;">Activity</label>
                    <textarea id="edit_activity" name="activity" rows="2" class="form-control" style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #ccc;"></textarea>
                </div>
                <div style="margin-bottom:1rem;">
                    <label style="font-weight:600; font-size:0.88rem;">Target</label>
                    <textarea id="edit_target" name="target" rows="2" class="form-control" style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #ccc;"></textarea>
                </div>
                <div style="margin-bottom:1rem;">
                    <label style="font-weight:600; font-size:0.88rem;">PIC <span style="color:red;">*</span></label>
                    <input type="text" id="edit_pic" name="pic" class="form-control" required style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #ccc;">
                </div>
                <div style="margin-bottom:1rem;">
                    <label style="font-weight:600; font-size:0.88rem;">Status</label>
                    <select id="edit_status" name="status" class="form-control" style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #ccc;">
                        <option value="Belum Dimulai">Belum Dimulai</option>
                        <option value="Berjalan">Berjalan</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
            </div>
            <div class="admin-modal-footer">
                <button type="button" class="btn btn-outline btn-sm" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Upload Dokumentasi -->
<div id="uploadDokModal" class="admin-modal-overlay">
    <div class="admin-modal">
        <div class="admin-modal-header">
            <h3><i class="fas fa-camera me-1"></i> Upload Foto Dokumentasi</h3>
            <button class="admin-modal-close" onclick="closeUploadModal()">&times;</button>
        </div>
        <form id="uploadDokForm" action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <div class="admin-modal-body">
                <p id="uploadDokProgramTitle" style="font-weight:600; font-size:0.9rem; margin-bottom:1rem; color:var(--primary);"></p>
                
                <div style="margin-bottom:1rem;">
                    <label style="font-weight:600; font-size:0.88rem;">Pilih Foto Kegiatan (Bisa >1 foto) <span style="color:red;">*</span></label>
                    <input type="file" name="dokumentasi_files[]" class="form-control" multiple accept="image/*" required style="width:100%; padding:0.5rem;">
                </div>
                <div style="margin-bottom:1rem;">
                    <label style="font-weight:600; font-size:0.88rem;">Caption / Keterangan Foto</label>
                    <input type="text" name="caption" class="form-control" placeholder="Contoh: Pembukaan kegiatan" style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #ccc;">
                </div>
            </div>
            <div class="admin-modal-footer">
                <button type="button" class="btn btn-outline btn-sm" onclick="closeUploadModal()">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Upload</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('addProkerModal').classList.add('active');
}
function closeAddModal() {
    document.getElementById('addProkerModal').classList.remove('active');
}

function openEditModal(id, nama, divisi, activity, target, pic, status) {
    document.getElementById('edit_nama_program').value = nama;
    document.getElementById('edit_divisi').value = divisi;
    document.getElementById('edit_activity').value = activity;
    document.getElementById('edit_target').value = target;
    document.getElementById('edit_pic').value = pic;
    document.getElementById('edit_status').value = status;

    document.getElementById('editProkerForm').action = `${BASE_URL}admin/program-kerja/edit/${id}`;
    document.getElementById('editProkerModal').classList.add('active');
}
function closeEditModal() {
    document.getElementById('editProkerModal').classList.remove('active');
}

function openUploadModal(id, nama) {
    document.getElementById('uploadDokProgramTitle').innerText = 'Program: ' + nama;
    document.getElementById('uploadDokForm').action = `${BASE_URL}admin/program-kerja/upload-dokumentasi/${id}`;
    document.getElementById('uploadDokModal').classList.add('active');
}
function closeUploadModal() {
    document.getElementById('uploadDokModal').classList.remove('active');
}
</script>

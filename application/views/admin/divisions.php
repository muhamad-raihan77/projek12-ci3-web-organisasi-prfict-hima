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
    <!-- Division List Table -->
    <div class="card-table">
        <div class="card-table-header">
            <h3>Daftar Divisi</h3>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Nama Divisi</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($divisions)): ?>
                        <?php foreach($divisions as $d): ?>
                            <tr>
                                <td>
                                    <div style="width:36px; height:36px; border-radius:6px; background:rgba(122,31,43,0.08); color:var(--primary); display:flex; align-items:center; justify-content:center;">
                                        <i class="fas <?= html_escape($d->icon); ?>"></i>
                                    </div>
                                </td>
                                <td><strong><?= html_escape($d->name); ?></strong></td>
                                <td style="max-width:250px; font-size:0.82rem; color:var(--gray);"><?= html_escape($d->description); ?></td>
                                <td>
                                    <?php if($d->is_active): ?>
                                        <span class="status-badge lolos">Aktif</span>
                                    <?php else: ?>
                                        <span class="status-badge tidak-lolos">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="display:flex; gap:0.35rem;">
                                        <a href="<?= base_url('admin/divisi/toggle/' . $d->id); ?>" class="btn btn-warning btn-sm" title="Toggle Aktif/Nonaktif">
                                            <i class="fas fa-power-off"></i>
                                        </a>
                                        <a href="<?= base_url('admin/divisi/delete/' . $d->id); ?>" class="btn btn-danger btn-sm btn-delete-confirm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center; color:var(--gray); padding:2rem;">Belum ada divisi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add New Division Card -->
    <div style="background:var(--white); padding:1.5rem; border-radius:var(--radius); border:1px solid var(--gray-light); box-shadow:0 1px 3px rgba(0,0,0,0.05); height:fit-content;">
        <h3 style="font-size:1rem; font-weight:700; margin-bottom:1rem;">Tambah Divisi Baru</h3>
        
        <?= form_open('admin/divisi/tambah'); ?>
            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Nama Divisi <span class="required">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: PSDM" required>
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Deskripsi Divisi <span class="required">*</span></label>
                <textarea name="description" class="form-control" placeholder="Jelaskan peran divisi ini..." style="min-height:80px;" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label style="font-size:0.82rem;">Icon (FontAwesome Class) <span class="required">*</span></label>
                <input type="text" name="icon" class="form-control" placeholder="fa-users" value="fa-users" required>
                <small style="font-size:0.75rem; color:var(--gray); display:block; margin-top:0.25rem;">Gunakan class FontAwesome 6, contoh: fa-bullhorn, fa-palette, fa-calendar-check</small>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="width:100%;">
                <i class="fas fa-plus me-1"></i> Tambah Divisi
            </button>
        <?= form_close(); ?>
    </div>
</div>

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

<!-- Filter & Search Bar -->
<div style="background:var(--white); padding:1.25rem 1.5rem; border-radius:var(--radius); border:1px solid var(--gray-light); margin-bottom:1.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
    <form method="GET" action="<?= base_url('admin/pendaftar'); ?>" style="display:flex; flex-wrap:wrap; gap:1rem; align-items:center;">
        <div style="flex:1; min-width:200px;">
            <input type="text" name="search" class="form-control" placeholder="Cari Nama / NIM / Kode..." value="<?= html_escape($filters['search']); ?>">
        </div>

        <div style="width:180px;">
            <select name="division_id" class="form-control">
                <option value="">-- Semua Divisi --</option>
                <?php foreach($divisions as $d): ?>
                    <option value="<?= $d->id; ?>" <?= ($filters['division_id'] == $d->id) ? 'selected' : ''; ?>>
                        <?= html_escape($d->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="width:180px;">
            <select name="status" class="form-control">
                <option value="">-- Semua Status --</option>
                <?php foreach(['Menunggu', 'Seleksi Administrasi', 'Interview', 'Lolos', 'Tidak Lolos'] as $st): ?>
                    <option value="<?= $st; ?>" <?= ($filters['status'] == $st) ? 'selected' : ''; ?>><?= $st; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-filter me-1"></i> Filter
            </button>
            <a href="<?= base_url('admin/pendaftar'); ?>" class="btn btn-outline btn-sm">Reset</a>
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="card-table">
    <div class="card-table-header">
        <div>
            <h3>Data Pendaftar (<?= $total; ?>)</h3>
        </div>
        <a href="<?= base_url('admin/export/csv?' . http_build_query($filters)); ?>" class="btn btn-outline btn-sm">
            <i class="fas fa-file-csv me-1"></i> Export CSV
        </a>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Lengkap</th>
                    <th>NIM</th>
                    <th>Prodi</th>
                    <th>Divisi</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($applicants)): ?>
                    <?php 
                        $no = ($current_page - 1) * $per_page + 1;
                        foreach($applicants as $a): 
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= html_escape($a->registration_code); ?></strong></td>
                            <td><?= html_escape($a->full_name); ?></td>
                            <td><?= html_escape($a->nim); ?></td>
                            <td><?= html_escape($a->study_program); ?></td>
                            <td><?= html_escape($a->division_name); ?></td>
                            <td>
                                <?php 
                                    $badge_class = 'menunggu';
                                    if ($a->status == 'Seleksi Administrasi') $badge_class = 'seleksi';
                                    elseif ($a->status == 'Interview') $badge_class = 'interview';
                                    elseif ($a->status == 'Lolos') $badge_class = 'lolos';
                                    elseif ($a->status == 'Tidak Lolos') $badge_class = 'tidak-lolos';
                                ?>
                                <span class="status-badge <?= $badge_class; ?>">
                                    <?= html_escape($a->status); ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($a->created_at)); ?></td>
                            <td>
                                <div style="display:flex; gap:0.35rem;">
                                    <a href="<?= base_url('admin/pendaftar/detail/' . $a->id); ?>" class="btn btn-primary btn-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/pendaftar/pdf/' . $a->id); ?>" class="btn btn-info btn-sm" title="Download PDF" target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="<?= base_url('admin/pendaftar/delete/' . $a->id); ?>" class="btn btn-danger btn-sm btn-delete-confirm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align:center; color:var(--gray); padding:2rem;">Data pendaftar tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($total_pages > 1): ?>
        <ul class="pagination">
            <?php for($p=1; $p<=$total_pages; $p++): ?>
                <li class="<?= ($p == $current_page) ? 'active' : ''; ?>">
                    <a href="<?= base_url('admin/pendaftar?' . http_build_query(array_merge($filters, ['page' => $p]))); ?>"><?= $p; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    <?php endif; ?>
</div>

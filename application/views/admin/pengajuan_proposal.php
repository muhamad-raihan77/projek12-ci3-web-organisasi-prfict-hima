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

<!-- Stats Grid -->
<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap:1rem; margin-bottom:1.5rem;">
    <div style="background:#fff; padding:1.25rem; border-radius:12px; border:1px solid #E5E7EB; border-left:4px solid var(--primary);">
        <small style="color:var(--gray); text-transform:uppercase; font-size:0.75rem; font-weight:700;">Total Proposal</small>
        <h3 style="font-size:1.5rem; font-weight:800; margin:0.2rem 0 0 0; color:var(--text-dark);"><?= isset($stats) ? $stats->total : 0; ?></h3>
    </div>
    <div style="background:#fff; padding:1.25rem; border-radius:12px; border:1px solid #E5E7EB; border-left:4px solid #3B82F6;">
        <small style="color:var(--gray); text-transform:uppercase; font-size:0.75rem; font-weight:700;">Submit</small>
        <h3 style="font-size:1.5rem; font-weight:800; margin:0.2rem 0 0 0; color:#1E40AF;"><?= isset($stats) ? $stats->submit : 0; ?></h3>
    </div>
    <div style="background:#fff; padding:1.25rem; border-radius:12px; border:1px solid #E5E7EB; border-left:4px solid #F59E0B;">
        <small style="color:var(--gray); text-transform:uppercase; font-size:0.75rem; font-weight:700;">Review</small>
        <h3 style="font-size:1.5rem; font-weight:800; margin:0.2rem 0 0 0; color:#D97706;"><?= isset($stats) ? $stats->review : 0; ?></h3>
    </div>
    <div style="background:#fff; padding:1.25rem; border-radius:12px; border:1px solid #E5E7EB; border-left:4px solid #EF4444;">
        <small style="color:var(--gray); text-transform:uppercase; font-size:0.75rem; font-weight:700;">Revisi</small>
        <h3 style="font-size:1.5rem; font-weight:800; margin:0.2rem 0 0 0; color:#DC2626;"><?= isset($stats) ? $stats->revisi : 0; ?></h3>
    </div>
    <div style="background:#fff; padding:1.25rem; border-radius:12px; border:1px solid #E5E7EB; border-left:4px solid #10B981;">
        <small style="color:var(--gray); text-transform:uppercase; font-size:0.75rem; font-weight:700;">Approve</small>
        <h3 style="font-size:1.5rem; font-weight:800; margin:0.2rem 0 0 0; color:#059669;"><?= isset($stats) ? $stats->approve : 0; ?></h3>
    </div>
</div>

<!-- Main Table Card -->
<div class="card-table">
    <div class="card-table-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
            <h3 style="font-size:1.1rem; font-weight:700; margin:0;">Kelola Pengajuan Proposal PDF</h3>
            <small style="color:var(--gray);">Daftar proposal pelaksanaan kegiatan dari mahasiswa & pendaftar</small>
        </div>
        <button class="btn btn-primary btn-sm" onclick="openAddModal()">
            <i class="fas fa-plus me-1"></i> Tambah Proposal Baru
        </button>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:40px; text-align:center;">No</th>
                    <th>Nama Program</th>
                    <th>Divisi</th>
                    <th>Pengaju / PIC</th>
                    <th>Tgl Pelaksanaan</th>
                    <th>Status</th>
                    <th>File PDF Proposal</th>
                    <th style="width:180px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($proposals)): ?>
                    <?php $no = 1; foreach ($proposals as $p): ?>
                        <tr>
                            <td style="text-align:center; font-weight:600;"><?= $no++; ?></td>
                            <td>
                                <strong><?= html_escape($p->nama_program); ?></strong>
                                <small style="display:block; color:var(--gray);"><i class="fas fa-map-marker-alt me-1"></i> <?= html_escape($p->lokasi); ?></small>
                            </td>
                            <td><span class="badge badge-info" style="background:#EFF6FF; color:var(--primary); padding:0.25rem 0.5rem; border-radius:4px; font-weight:600; font-size:0.8rem;"><?= html_escape($p->divisi); ?></span></td>
                            <td>
                                <strong><?= html_escape($p->pic); ?></strong>
                                <?php if($p->student_name): ?>
                                    <small style="display:block; color:var(--gray);">(User: <?= html_escape($p->student_name); ?>)</small>
                                <?php endif; ?>
                            </td>
                            <td style="white-space:nowrap; font-size:0.85rem;"><?= date('d/m/Y', strtotime($p->tanggal_pelaksanaan)); ?></td>
                            <td>
                                <?php
                                    $status_color = '#6B7280';
                                    $status_bg = '#F3F4F6';
                                    if ($p->status == 'Submit') { $status_color = '#1E40AF'; $status_bg = '#DBEAFE'; }
                                    else if ($p->status == 'Review') { $status_color = '#92400E'; $status_bg = '#FEF3C7'; }
                                    else if ($p->status == 'Revisi') { $status_color = '#991B1B'; $status_bg = '#FEE2E2'; }
                                    else if ($p->status == 'Approve') { $status_color = '#065F46'; $status_bg = '#D1FAE5'; }
                                    else if ($p->status == 'Ditolak') { $status_color = '#374151'; $status_bg = '#E5E7EB'; }
                                ?>
                                <button type="button" class="btn btn-sm" onclick="openStatusModal(<?= $p->id; ?>, '<?= html_escape($p->status); ?>', '<?= html_escape(addslashes($p->catatan_revisi)); ?>')" 
                                        style="background:<?= $status_bg; ?>; color:<?= $status_color; ?>; border:none; padding:0.3rem 0.6rem; border-radius:50px; font-weight:700; font-size:0.75rem; cursor:pointer;">
                                    <i class="fas fa-edit me-1"></i> <?= $p->status; ?>
                                </button>
                            </td>
                            <td>
                                <?php if($p->proposal_file): ?>
                                    <a href="<?= base_url('uploads/proposal_files/' . $p->proposal_file); ?>" target="_blank" class="btn btn-outline btn-sm" style="padding:0.25rem 0.5rem; font-size:0.78rem; color:#DC2626; border-color:#FCA5A5;">
                                        <i class="fas fa-file-pdf me-1"></i> Lihat PDF
                                    </a>
                                <?php else: ?>
                                    <small style="color:var(--gray); font-style:italic;">Tidak Ada File</small>
                                <?php endif; ?>
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex; justify-content:center; gap:0.25rem;">
                                    <button class="btn btn-outline btn-sm" style="padding:0.25rem 0.5rem; font-size:0.8rem; color:var(--primary);" title="Detail Proposal"
                                            onclick="openDetailModal(<?= html_escape(json_encode($p)); ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <a href="<?= base_url('admin/pengajuan-proposal/pdf/' . $p->id); ?>" target="_blank" class="btn btn-outline btn-sm" style="padding:0.25rem 0.5rem; font-size:0.8rem; color:#059669;" title="Cetak Rangkuman PDF">
                                        <i class="fas fa-print"></i>
                                    </a>

                                    <button class="btn btn-outline btn-sm" style="padding:0.25rem 0.5rem; font-size:0.8rem; color:#D97706;" title="Edit Data"
                                            onclick="openEditModal(<?= html_escape(json_encode($p)); ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <a href="<?= base_url('admin/pengajuan-proposal/delete/' . $p->id); ?>" class="btn btn-danger btn-sm" style="padding:0.25rem 0.5rem; font-size:0.8rem; background:#EF4444; border-color:#EF4444;" onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan proposal ini?');" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align:center; padding:2rem; color:var(--gray);">Belum ada pengajuan proposal.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH PROPOSAL -->
<div id="addModal" class="modal-backdrop" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:#fff; border-radius:12px; max-width:650px; width:90%; max-height:90vh; overflow-y:auto; padding:1.75rem; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem; border-bottom:1px solid #E5E7EB; padding-bottom:0.75rem;">
            <h4 style="margin:0; font-weight:700;">Tambah Proposal Pelaksanaan</h4>
            <button onclick="closeAddModal()" style="background:none; border:none; font-size:1.2rem; cursor:pointer; color:var(--gray);">&times;</button>
        </div>
        <form action="<?= base_url('admin/pengajuan-proposal/add'); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label style="font-weight:600; font-size:0.85rem;">Nama Program / Kegiatan *</label>
                <input type="text" name="nama_program" class="form-control" required style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px;">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;" class="mb-3">
                <div>
                    <label style="font-weight:600; font-size:0.85rem;">Divisi *</label>
                    <select name="divisi" class="form-control" required style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px;">
                        <option value="">-- Pilih Divisi --</option>
                        <?php if(!empty($divisions)): ?>
                            <?php foreach($divisions as $d): ?>
                                <option value="<?= html_escape($d->name); ?>"><?= html_escape($d->name); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div>
                    <label style="font-weight:600; font-size:0.85rem;">PIC / Penanggung Jawab *</label>
                    <input type="text" name="pic" class="form-control" required style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px;">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;" class="mb-3">
                <div>
                    <label style="font-weight:600; font-size:0.85rem;">Tanggal Pelaksanaan *</label>
                    <input type="date" name="tanggal_pelaksanaan" class="form-control" required style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px;">
                </div>
                <div>
                    <label style="font-weight:600; font-size:0.85rem;">Lokasi Kegiatan *</label>
                    <input type="text" name="lokasi" class="form-control" required style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px;">
                </div>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight:600; font-size:0.85rem;">Projek Brief *</label>
                <textarea name="projek_brief" rows="3" class="form-control" required style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px; font-family:inherit;"></textarea>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight:600; font-size:0.85rem;">Berkas Proposal (PDF)</label>
                <input type="file" name="proposal_file" accept="application/pdf" class="form-control" style="width:100%;">
            </div>
            <div class="form-group mb-3">
                <label style="font-weight:600; font-size:0.85rem;">Status awal</label>
                <select name="status" class="form-control" style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px;">
                    <option value="Submit">Submit</option>
                    <option value="Review">Review</option>
                    <option value="Revisi">Revisi</option>
                    <option value="Approve">Approve</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:0.5rem; margin-top:1.25rem;">
                <button type="button" onclick="closeAddModal()" class="btn btn-outline btn-sm">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT PROPOSAL -->
<div id="editModal" class="modal-backdrop" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:#fff; border-radius:12px; max-width:650px; width:90%; max-height:90vh; overflow-y:auto; padding:1.75rem; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem; border-bottom:1px solid #E5E7EB; padding-bottom:0.75rem;">
            <h4 style="margin:0; font-weight:700;">Edit Pengajuan Proposal</h4>
            <button onclick="closeEditModal()" style="background:none; border:none; font-size:1.2rem; cursor:pointer; color:var(--gray);">&times;</button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label style="font-weight:600; font-size:0.85rem;">Nama Program / Kegiatan *</label>
                <input type="text" name="nama_program" id="edit_nama_program" class="form-control" required style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px;">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;" class="mb-3">
                <div>
                    <label style="font-weight:600; font-size:0.85rem;">Divisi *</label>
                    <select name="divisi" id="edit_divisi" class="form-control" required style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px;">
                        <?php if(!empty($divisions)): ?>
                            <?php foreach($divisions as $d): ?>
                                <option value="<?= html_escape($d->name); ?>"><?= html_escape($d->name); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div>
                    <label style="font-weight:600; font-size:0.85rem;">PIC / Penanggung Jawab *</label>
                    <input type="text" name="pic" id="edit_pic" class="form-control" required style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px;">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;" class="mb-3">
                <div>
                    <label style="font-weight:600; font-size:0.85rem;">Tanggal Pelaksanaan *</label>
                    <input type="date" name="tanggal_pelaksanaan" id="edit_tanggal_pelaksanaan" class="form-control" required style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px;">
                </div>
                <div>
                    <label style="font-weight:600; font-size:0.85rem;">Lokasi Kegiatan *</label>
                    <input type="text" name="lokasi" id="edit_lokasi" class="form-control" required style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px;">
                </div>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight:600; font-size:0.85rem;">Projek Brief *</label>
                <textarea name="projek_brief" id="edit_projek_brief" rows="3" class="form-control" required style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px; font-family:inherit;"></textarea>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight:600; font-size:0.85rem;">Ganti File Proposal (PDF)</label>
                <input type="file" name="proposal_file" accept="application/pdf" class="form-control" style="width:100%;">
                <small id="edit_file_info" style="color:var(--gray); display:block; margin-top:0.25rem;"></small>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:0.5rem; margin-top:1.25rem;">
                <button type="button" onclick="closeEditModal()" class="btn btn-outline btn-sm">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Perbarui Data</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL UPDATE STATUS & REVISI -->
<div id="statusModal" class="modal-backdrop" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:#fff; border-radius:12px; max-width:500px; width:90%; padding:1.75rem; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem; border-bottom:1px solid #E5E7EB; padding-bottom:0.75rem;">
            <h4 style="margin:0; font-weight:700;">Update Status Proposal</h4>
            <button onclick="closeStatusModal()" style="background:none; border:none; font-size:1.2rem; cursor:pointer; color:var(--gray);">&times;</button>
        </div>
        <form id="statusForm" method="POST">
            <div class="form-group mb-3">
                <label style="font-weight:600; font-size:0.85rem;">Pilih Status Pengajuan</label>
                <select name="status" id="status_select" class="form-control" required style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px; font-weight:600;">
                    <option value="Submit">Submit (Diterima)</option>
                    <option value="Review">Review (Sedang Ditinjau)</option>
                    <option value="Revisi">Revisi (Perlu Perbaikan)</option>
                    <option value="Approve">Approve (Disetujui)</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight:600; font-size:0.85rem;">Catatan Revisi / Umpan Balik Admin</label>
                <textarea name="catatan_revisi" id="status_catatan_revisi" rows="3" class="form-control" placeholder="Tuliskan catatan revisi atau instruksi perbaikan bagi mahasiswa..." style="width:100%; padding:0.6rem 0.8rem; border:1px solid #D1D5DB; border-radius:6px; font-family:inherit;"></textarea>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:0.5rem; margin-top:1.25rem;">
                <button type="button" onclick="closeStatusModal()" class="btn btn-outline btn-sm">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan Status</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL DETAIL PROPOSAL -->
<div id="detailModal" class="modal-backdrop" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:#fff; border-radius:12px; max-width:650px; width:90%; max-height:90vh; overflow-y:auto; padding:1.75rem; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem; border-bottom:1px solid #E5E7EB; padding-bottom:0.75rem;">
            <h4 style="margin:0; font-weight:700;" id="detail_nama_program">Detail Pengajuan Proposal</h4>
            <button onclick="closeDetailModal()" style="background:none; border:none; font-size:1.2rem; cursor:pointer; color:var(--gray);">&times;</button>
        </div>
        <div id="detailContent">
            <!-- Dynamic Javascript Content -->
        </div>
        <div style="display:flex; justify-content:flex-end; gap:0.5rem; margin-top:1.5rem; border-top:1px solid #E5E7EB; padding-top:1rem;">
            <button type="button" onclick="closeDetailModal()" class="btn btn-outline btn-sm">Tutup</button>
        </div>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('addModal').style.display = 'flex';
}
function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
}

function openEditModal(proposal) {
    document.getElementById('editForm').action = BASE_URL + 'admin/pengajuan-proposal/edit/' + proposal.id;
    document.getElementById('edit_nama_program').value = proposal.nama_program;
    document.getElementById('edit_divisi').value = proposal.divisi;
    document.getElementById('edit_pic').value = proposal.pic;
    document.getElementById('edit_tanggal_pelaksanaan').value = proposal.tanggal_pelaksanaan;
    document.getElementById('edit_lokasi').value = proposal.lokasi;
    document.getElementById('edit_projek_brief').value = proposal.projek_brief;
    
    if (proposal.proposal_file) {
        document.getElementById('edit_file_info').innerHTML = 'File saat ini: <a href="' + BASE_URL + 'uploads/proposal_files/' + proposal.proposal_file + '" target="_blank">' + proposal.proposal_file + '</a>';
    } else {
        document.getElementById('edit_file_info').innerHTML = 'Belum ada file terunggah.';
    }

    document.getElementById('editModal').style.display = 'flex';
}
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

function openStatusModal(id, currentStatus, currentNotes) {
    document.getElementById('statusForm').action = BASE_URL + 'admin/pengajuan-proposal/update-status/' + id;
    document.getElementById('status_select').value = currentStatus;
    document.getElementById('status_catatan_revisi').value = currentNotes || '';
    document.getElementById('statusModal').style.display = 'flex';
}
function closeStatusModal() {
    document.getElementById('statusModal').style.display = 'none';
}

function openDetailModal(p) {
    document.getElementById('detail_nama_program').innerText = p.nama_program;
    
    var pdfLink = p.proposal_file ? 
        '<a href="' + BASE_URL + 'uploads/proposal_files/' + p.proposal_file + '" target="_blank" class="btn btn-outline btn-sm" style="color:#DC2626; border-color:#FCA5A5;"><i class="fas fa-file-pdf me-1"></i> Buka File Proposal PDF</a>' : 
        '<span style="color:var(--gray);">Belum mengunggah PDF</span>';

    var html = '<table style="width:100%; font-size:0.9rem; border-collapse:collapse;" class="mb-3">' +
        '<tr><td style="padding:0.4rem 0; width:35%; font-weight:600;">Divisi:</td><td>' + (p.divisi || '-') + '</td></tr>' +
        '<tr><td style="padding:0.4rem 0; font-weight:600;">PIC:</td><td>' + (p.pic || '-') + '</td></tr>' +
        '<tr><td style="padding:0.4rem 0; font-weight:600;">Tanggal Pelaksanaan:</td><td>' + (p.tanggal_pelaksanaan || '-') + '</td></tr>' +
        '<tr><td style="padding:0.4rem 0; font-weight:600;">Lokasi:</td><td>' + (p.lokasi || '-') + '</td></tr>' +
        '<tr><td style="padding:0.4rem 0; font-weight:600;">Status:</td><td><strong>' + (p.status || '-') + '</strong></td></tr>' +
        '<tr><td style="padding:0.4rem 0; font-weight:600;">File PDF Proposal:</td><td>' + pdfLink + '</td></tr>' +
        '</table>' +
        '<div style="margin-top:1rem; background:#F9FAFB; padding:1rem; border-radius:8px; border:1px solid #E5E7EB;">' +
        '<h5 style="margin:0 0 0.5rem 0; font-weight:700;">Projek Brief:</h5>' +
        '<p style="margin:0; font-size:0.875rem; white-space:pre-line; color:#374151;">' + (p.projek_brief || '-') + '</p>' +
        '</div>';

    if (p.catatan_revisi) {
        html += '<div style="margin-top:1rem; background:#FEF2F2; padding:1rem; border-radius:8px; border:1px solid #FCA5A5; color:#991B1B;">' +
            '<h5 style="margin:0 0 0.5rem 0; font-weight:700;"><i class="fas fa-exclamation-triangle me-1"></i> Catatan Revisi Admin:</h5>' +
            '<p style="margin:0; font-size:0.875rem; white-space:pre-line;">' + p.catatan_revisi + '</p>' +
            '</div>';
    }

    document.getElementById('detailContent').innerHTML = html;
    document.getElementById('detailModal').style.display = 'flex';
}
function closeDetailModal() {
    document.getElementById('detailModal').style.display = 'none';
}
</script>

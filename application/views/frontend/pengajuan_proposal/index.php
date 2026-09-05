<div class="page-header">
    <div class="container">
        <h1>Pengajuan Proposal Program Kerja</h1>
        <p>Kelola dan pantau status pengajuan proposal pelaksanaan kegiatan organisasi Anda</p>
    </div>
</div>

<section class="form-section" style="padding: 3rem 0;">
    <div class="container">

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

        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; margin-bottom:2rem;">
            <div>
                <h2 style="font-size:1.4rem; font-weight:700; color:var(--text-dark); margin:0;">Daftar Proposal Saya</h2>
                <p style="color:var(--gray); font-size:0.9rem; margin:0.25rem 0 0 0;">Riwayat pengajuan proposal kegiatan yang pernah Anda kirimkan.</p>
            </div>
            <a href="<?= base_url('pengajuan-proposal/tambah'); ?>" class="btn btn-primary">
                <i class="fas fa-file-upload me-2"></i> Ajukan Proposal PDF Baru
            </a>
        </div>

        <?php if(empty($proposals)): ?>
            <div style="background:#fff; text-align:center; padding:4rem 2rem; border-radius:16px; border:1px solid #E5E7EB; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                <div style="width:80px; height:80px; background:#EFF6FF; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; color:var(--primary); font-size:2.2rem; margin-bottom:1.25rem;">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <h3 style="font-size:1.2rem; font-weight:700; color:var(--text-dark); margin-bottom:0.5rem;">Belum Ada Pengajuan Proposal</h3>
                <p style="color:var(--gray); font-size:0.925rem; max-width:480px; margin:0 auto 1.5rem auto;">
                    Anda belum pernah mengirimkan pengajuan proposal kegiatan. Klik tombol di bawah untuk membuat pengajuan baru dan mengunggah berkas PDF.
                </p>
                <a href="<?= base_url('pengajuan-proposal/tambah'); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Buat Pengajuan Baru
                </a>
            </div>
        <?php else: ?>
            <div style="display:grid; grid-template-columns: 1fr; gap:1.5rem;">
                <?php foreach($proposals as $p): ?>
                    <div style="background:#fff; border-radius:16px; border:1px solid #E5E7EB; box-shadow:0 2px 10px rgba(0,0,0,0.03); padding:1.75rem; position:relative; overflow:hidden;">
                        <!-- Status Badge Header -->
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:1rem; margin-bottom:1rem; border-bottom:1px solid #F3F4F6; padding-bottom:1rem;">
                            <div>
                                <span style="background:#EFF6FF; color:var(--primary); padding:0.25rem 0.75rem; border-radius:50px; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;">
                                    Divisi: <?= html_escape($p->divisi); ?>
                                </span>
                                <h3 style="font-size:1.25rem; font-weight:700; color:var(--text-dark); margin:0.5rem 0 0.25rem 0;">
                                    <?= html_escape($p->nama_program); ?>
                                </h3>
                                <div style="font-size:0.85rem; color:var(--gray); display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
                                    <span><i class="fas fa-user me-1"></i> PIC: <strong><?= html_escape($p->pic); ?></strong></span>
                                    <span><i class="fas fa-calendar-alt me-1"></i> Tanggal: <?= date('d M Y', strtotime($p->tanggal_pelaksanaan)); ?></span>
                                    <span><i class="fas fa-map-marker-alt me-1"></i> Lokasi: <?= html_escape($p->lokasi); ?></span>
                                </div>
                            </div>

                            <div>
                                <?php
                                    $badge_class = 'bg-secondary';
                                    $badge_style = 'background:#E5E7EB; color:#374151;';
                                    if ($p->status == 'Submit') {
                                        $badge_style = 'background:#DBEAFE; color:#1E40AF;';
                                    } else if ($p->status == 'Review') {
                                        $badge_style = 'background:#FEF3C7; color:#92400E;';
                                    } else if ($p->status == 'Revisi') {
                                        $badge_style = 'background:#FEE2E2; color:#991B1B;';
                                    } else if ($p->status == 'Approve') {
                                        $badge_style = 'background:#D1FAE5; color:#065F46;';
                                    } else if ($p->status == 'Ditolak') {
                                        $badge_style = 'background:#F3F4F6; color:#1F2937;';
                                    }
                                ?>
                                <span style="<?= $badge_style; ?> padding:0.5rem 1rem; border-radius:50px; font-weight:700; font-size:0.85rem; display:inline-flex; align-items:center; gap:0.4rem;">
                                    <i class="fas fa-circle" style="font-size:0.5rem;"></i> <?= $p->status; ?>
                                </span>
                            </div>
                        </div>

                        <!-- Brief & Details -->
                        <div style="margin-bottom:1.25rem;">
                            <h4 style="font-size:0.9rem; font-weight:700; color:var(--text-dark); margin-bottom:0.25rem;">Projek Brief:</h4>
                            <p style="font-size:0.9rem; color:#4B5563; margin:0; line-height:1.5; white-space:pre-line;"><?= html_escape($p->projek_brief); ?></p>
                        </div>

                        <?php if($p->catatan): ?>
                            <div style="background:#F9FAFB; padding:0.75rem 1rem; border-radius:8px; font-size:0.85rem; color:#6B7280; margin-bottom:1rem;">
                                <strong>Catatan Pengajuan:</strong> <?= html_escape($p->catatan); ?>
                            </div>
                        <?php endif; ?>

                        <?php if($p->status == 'Revisi' && $p->catatan_revisi): ?>
                            <div style="background:#FEF2F2; border:1px solid #FCA5A5; color:#991B1B; padding:0.85rem 1.1rem; border-radius:8px; font-size:0.875rem; margin-bottom:1.25rem;">
                                <strong style="display:block; margin-bottom:0.2rem;"><i class="fas fa-exclamation-triangle me-1"></i> Catatan Revisi dari Admin:</strong>
                                <?= html_escape($p->catatan_revisi); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Action buttons -->
                        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.75rem; background:#F9FAFB; padding:0.85rem 1.1rem; border-radius:10px; border:1px solid #F3F4F6;">
                            <div style="display:flex; align-items:center; gap:0.5rem; flex-wrap:wrap;">
                                <?php if($p->proposal_file): ?>
                                    <a href="<?= base_url('uploads/proposal_files/' . $p->proposal_file); ?>" target="_blank" class="btn btn-outline btn-sm" style="background:#fff; border-color:#CBD5E1; color:var(--text-dark);">
                                        <i class="fas fa-file-pdf me-1" style="color:#DC2626;"></i> Open Uploaded Proposal PDF
                                    </a>
                                <?php endif; ?>

                                <a href="<?= base_url('pengajuan-proposal/pdf/' . $p->id); ?>" target="_blank" class="btn btn-outline btn-sm" style="background:#fff; border-color:#CBD5E1; color:var(--text-dark);">
                                    <i class="fas fa-download me-1" style="color:var(--primary);"></i> Download Summary PDF
                                </a>
                            </div>

                            <div style="display:flex; align-items:center; gap:0.5rem;">
                                <a href="<?= base_url('pengajuan-proposal/edit/' . $p->id); ?>" class="btn btn-warning btn-sm" style="background:#F59E0B; border-color:#F59E0B; color:#fff;">
                                    <i class="fas fa-edit me-1"></i> <?= ($p->status == 'Revisi') ? 'Upload Revisi' : 'Edit'; ?>
                                </a>
                                <a href="<?= base_url('pengajuan-proposal/delete/' . $p->id); ?>" class="btn btn-danger btn-sm" style="background:#EF4444; border-color:#EF4444; color:#fff;" onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan proposal ini?');">
                                    <i class="fas fa-trash-alt me-1"></i> Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

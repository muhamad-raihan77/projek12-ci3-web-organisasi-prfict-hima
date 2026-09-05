<div class="page-header">
    <div class="container">
        <h1><?= isset($proposal) ? 'Edit / Revisi Proposal' : 'Form Pengajuan Proposal PDF'; ?></h1>
        <p><?= isset($proposal) ? 'Perbarui data atau unggah ulang berkas PDF proposal Anda.' : 'Lengkapi formulir di bawah ini dan unggah berkas proposal dalam format PDF.'; ?></p>
    </div>
</div>

<section class="form-section" style="padding: 3rem 0;">
    <div class="container" style="max-width: 800px;">

        <div style="margin-bottom:1.5rem;">
            <a href="<?= base_url('pengajuan-proposal'); ?>" style="color:var(--primary); font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem;">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Proposal
            </a>
        </div>

        <?php if(!empty($upload_error)): ?>
            <div class="alert alert-error mb-4" style="background:#FEE2E2; color:#991B1B; padding:1rem 1.25rem; border-radius:8px; margin-bottom:1.5rem; border:1px solid #FCA5A5; display:flex; align-items:center; gap:0.75rem;">
                <i class="fas fa-exclamation-circle" style="font-size:1.25rem;"></i>
                <div><?= $upload_error; ?></div>
            </div>
        <?php endif; ?>

        <?php if(validation_errors()): ?>
            <div class="alert alert-error mb-4" style="background:#FEE2E2; color:#991B1B; padding:1rem 1.25rem; border-radius:8px; margin-bottom:1.5rem; border:1px solid #FCA5A5;">
                <strong style="display:block; margin-bottom:0.4rem;">Perhatikan kesalahan berikut:</strong>
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>

        <div style="background:#fff; border-radius:16px; border:1px solid #E5E7EB; box-shadow:0 4px 20px rgba(0,0,0,0.05); padding:2rem;">
            
            <form action="<?= isset($proposal) ? base_url('pengajuan-proposal/edit/' . $proposal->id) : base_url('pengajuan-proposal/tambah'); ?>" method="POST" enctype="multipart/form-data">
                
                <div class="form-group mb-3">
                    <label style="font-weight:600; font-size:0.9rem; color:var(--text-dark); margin-bottom:0.4rem; display:block;">
                        Nama Program / Kegiatan <span style="color:#DC2626;">*</span>
                    </label>
                    <input type="text" name="nama_program" class="form-control" placeholder="Contoh: Workshop Web Development 2026" value="<?= set_value('nama_program', isset($proposal) ? $proposal->nama_program : ''); ?>" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px;">
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem;" class="mb-3">
                    <div class="form-group">
                        <label style="font-weight:600; font-size:0.9rem; color:var(--text-dark); margin-bottom:0.4rem; display:block;">
                            Divisi Penyelenggara <span style="color:#DC2626;">*</span>
                        </label>
                        <select name="divisi" class="form-control" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px;">
                            <option value="">-- Pilih Divisi --</option>
                            <?php if(!empty($divisions)): ?>
                                <?php foreach($divisions as $d): ?>
                                    <option value="<?= html_escape($d->name); ?>" <?= (set_value('divisi', isset($proposal) ? $proposal->divisi : '') == $d->name) ? 'selected' : ''; ?>>
                                        <?= html_escape($d->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="PSDM">PSDM</option>
                                <option value="Humas">Humas</option>
                                <option value="Media & Kreatif">Media & Kreatif</option>
                                <option value="Acara">Acara</option>
                                <option value="Kominfo">Kominfo</option>
                                <option value="Advokasi">Advokasi</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="font-weight:600; font-size:0.9rem; color:var(--text-dark); margin-bottom:0.4rem; display:block;">
                            PIC / Penanggung Jawab <span style="color:#DC2626;">*</span>
                        </label>
                        <input type="text" name="pic" class="form-control" placeholder="Nama Ketua Pelaksana / PIC" value="<?= set_value('pic', isset($proposal) ? $proposal->pic : (isset($user) ? $user->full_name : '')); ?>" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px;">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem;" class="mb-3">
                    <div class="form-group">
                        <label style="font-weight:600; font-size:0.9rem; color:var(--text-dark); margin-bottom:0.4rem; display:block;">
                            Tanggal Pelaksanaan <span style="color:#DC2626;">*</span>
                        </label>
                        <input type="date" name="tanggal_pelaksanaan" class="form-control" value="<?= set_value('tanggal_pelaksanaan', isset($proposal) ? $proposal->tanggal_pelaksanaan : ''); ?>" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px;">
                    </div>

                    <div class="form-group">
                        <label style="font-weight:600; font-size:0.9rem; color:var(--text-dark); margin-bottom:0.4rem; display:block;">
                            Lokasi Kegiatan <span style="color:#DC2626;">*</span>
                        </label>
                        <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Aula Kampus A / Zoom Meeting" value="<?= set_value('lokasi', isset($proposal) ? $proposal->lokasi : ''); ?>" required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px;">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label style="font-weight:600; font-size:0.9rem; color:var(--text-dark); margin-bottom:0.4rem; display:block;">
                        Projek Brief / Deskripsi Kegiatan <span style="color:#DC2626;">*</span>
                    </label>
                    <textarea name="projek_brief" rows="4" class="form-control" placeholder="Jelaskan secara ringkas latar belakang, tujuan, dan alur kegiatan..." required style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-family:inherit;"><?= set_value('projek_brief', isset($proposal) ? $proposal->projek_brief : ''); ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label style="font-weight:600; font-size:0.9rem; color:var(--text-dark); margin-bottom:0.4rem; display:block;">
                        Berkas Proposal PDF <span style="color:#DC2626;"><?= isset($proposal) ? '' : '*'; ?></span>
                    </label>
                    <div style="border:2px dashed #CBD5E1; border-radius:12px; padding:1.5rem; text-align:center; background:#F8FAFC;">
                        <i class="fas fa-file-pdf" style="font-size:2.5rem; color:#DC2626; margin-bottom:0.75rem;"></i>
                        <p style="margin:0 0 0.5rem 0; font-weight:600; font-size:0.95rem; color:var(--text-dark);">
                            Pilih berkas PDF Proposal
                        </p>
                        <p style="margin:0 0 1rem 0; font-size:0.8rem; color:var(--gray);">Format disarankan: PDF (Maksimal 10 MB)</p>
                        
                        <input type="file" name="proposal_file" accept="application/pdf" style="max-width:300px; margin:0 auto;" <?= isset($proposal) ? '' : 'required'; ?>>

                        <?php if(isset($proposal) && $proposal->proposal_file): ?>
                            <div style="margin-top:1rem; padding:0.5rem 0.75rem; background:#EFF6FF; border-radius:6px; display:inline-block; font-size:0.85rem; color:var(--primary);">
                                <i class="fas fa-paperclip me-1"></i> File Terunggah: 
                                <a href="<?= base_url('uploads/proposal_files/' . $proposal->proposal_file); ?>" target="_blank" style="font-weight:600; text-decoration:underline;">
                                    <?= html_escape($proposal->proposal_file); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label style="font-weight:600; font-size:0.9rem; color:var(--text-dark); margin-bottom:0.4rem; display:block;">
                        Catatan Tambahan (Opsional)
                    </label>
                    <textarea name="catatan" rows="2" class="form-control" placeholder="Tambahkan catatan khusus apabila ada..." style="width:100%; padding:0.75rem 1rem; border:1px solid #D1D5DB; border-radius:8px; font-family:inherit;"><?= set_value('catatan', isset($proposal) ? $proposal->catatan : ''); ?></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:0.75rem;">
                    <a href="<?= base_url('pengajuan-proposal'); ?>" class="btn btn-outline" style="border-color:#D1D5DB; color:var(--text-dark);">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> <?= isset($proposal) ? 'Simpan & Kirim Ulang' : 'Kirim Pengajuan Proposal'; ?>
                    </button>
                </div>

            </form>

        </div>
    </div>
</section>

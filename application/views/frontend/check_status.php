    <div class="status-page">
        <div class="container">
            
            <div class="status-form-card">
                <h2>Cek Status Pendaftaran</h2>
                <p class="desc">Masukkan kode pendaftaran Anda untuk melihat perkembangan seleksi.</p>

                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-error mb-3">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <?= form_open('cek-status/hasil'); ?>
                <div class="status-input-group">
                    <input type="text" name="registration_code" class="form-control" placeholder="Contoh: PRFICT-2026-0001" value="<?= isset($_POST['registration_code']) ? html_escape($_POST['registration_code']) : ''; ?>" required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i> CEK
                    </button>
                </div>
                <?= form_close(); ?>
            </div>

            <?php if(isset($searched)): ?>
                <?php if(isset($not_found)): ?>
                    <div class="not-found-card">
                        <i class="fas fa-search-minus"></i>
                        <h3>Data Tidak Ditemukan</h3>
                        <p>Kode pendaftaran yang Anda masukkan tidak terdaftar dalam sistem. Mohon periksa kembali kode Anda.</p>
                    </div>
                <?php elseif(isset($applicant) && $applicant): ?>
                    
                    <div class="status-result">
                        <div class="status-card">
                            <div class="status-header">
                                <div class="status-header-info">
                                    <h3><?= html_escape($applicant->full_name); ?></h3>
                                    <p><?= html_escape($applicant->registration_code); ?> • <?= html_escape($applicant->study_program); ?></p>
                                </div>
                                <div>
                                    <?php 
                                        $badge_class = 'menunggu';
                                        if ($applicant->status == 'Seleksi Administrasi') $badge_class = 'seleksi';
                                        elseif ($applicant->status == 'Interview') $badge_class = 'interview';
                                        elseif ($applicant->status == 'Lolos') $badge_class = 'lolos';
                                        elseif ($applicant->status == 'Tidak Lolos') $badge_class = 'tidak-lolos';
                                    ?>
                                    <span class="status-badge <?= $badge_class; ?>">
                                        <?= strtoupper(html_escape($applicant->status)); ?>
                                    </span>
                                </div>
                            </div>

                            <div class="status-info-grid">
                                <div class="status-info-item">
                                    <div class="label">NIM</div>
                                    <div class="value"><?= html_escape($applicant->nim); ?></div>
                                </div>
                                <div class="status-info-item">
                                    <div class="label">Pilihan Divisi</div>
                                    <div class="value"><?= html_escape($applicant->division_name); ?></div>
                                </div>
                            </div>

                            <!-- Timeline Progress -->
                            <div class="status-timeline">
                                <h4>Progres Seleksi:</h4>

                                <?php
                                    $statuses = ['Menunggu', 'Seleksi Administrasi', 'Interview', 'Lolos'];
                                    $current_idx = array_search($applicant->status, $statuses);
                                    if ($applicant->status == 'Tidak Lolos') $current_idx = 1; // Show stuck after admin selection or interview
                                ?>

                                <div class="status-step <?= ($current_idx !== false && $current_idx >= 0) ? 'completed' : 'pending'; ?>">
                                    <div class="step-icon"><i class="fas fa-check"></i></div>
                                    <div class="step-text">Pendaftaran Diterima</div>
                                </div>

                                <div class="status-step <?= ($current_idx !== false && $current_idx >= 1) ? (($current_idx == 1) ? 'current' : 'completed') : 'pending'; ?>">
                                    <div class="step-icon">
                                        <?php if($current_idx == 1): ?><i class="fas fa-spinner fa-spin"></i><?php else: ?><i class="fas fa-check"></i><?php endif; ?>
                                    </div>
                                    <div class="step-text">Seleksi Administrasi</div>
                                </div>

                                <div class="status-step <?= ($current_idx !== false && $current_idx >= 2) ? (($current_idx == 2) ? 'current' : 'completed') : 'pending'; ?>">
                                    <div class="step-icon">
                                        <?php if($current_idx == 2): ?><i class="fas fa-spinner fa-spin"></i><?php else: ?><i class="fas fa-check"></i><?php endif; ?>
                                    </div>
                                    <div class="step-text">Interview / Wawancara</div>
                                </div>

                                <div class="status-step <?= ($current_idx !== false && $current_idx == 3) ? 'completed' : 'pending'; ?>">
                                    <div class="step-icon"><i class="fas fa-bullhorn"></i></div>
                                    <div class="step-text">
                                        <?php if($applicant->status == 'Lolos'): ?>
                                            <strong class="text-success">Selamat! Anda Dinyatakan LOLOS</strong>
                                        <?php elseif($applicant->status == 'Tidak Lolos'): ?>
                                            <strong class="text-danger">Mohon Maaf, Anda BELUM LOLOS</strong>
                                        <?php else: ?>
                                            Pengumuman Akhir
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>

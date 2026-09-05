    <div class="page-header">
        <div class="container">
            <h1>Dashboard Calon Anggota</h1>
            <p>Selamat Datang, <strong><?= htmlspecialchars($user->full_name); ?></strong> (Mahasiswa FICT)</p>
        </div>
    </div>

    <!-- Dynamic Flow Stepper -->
    <div style="background:#F9FAFB; border-bottom:1px solid #E5E7EB;">
        <div class="container" style="padding:1.25rem 0;">
            <?php
                // Determine step states
                $step1_style = 'background:#D1FAE5; color:#065F46;'; // Always completed (registered)
                $step2_style = 'background:#D1FAE5; color:#065F46;'; // Always completed (logged in)
                
                if ($is_complete && $applicant) {
                    // All done
                    $step3_style = 'background:#D1FAE5; color:#065F46;';
                    $step4_style = 'background:#D1FAE5; color:#065F46;';
                    $step3_icon = 'fa-check-circle';
                    $step4_icon = 'fa-check-circle';
                } else if ($is_complete && !$applicant) {
                    // Biodata done, belum daftar org
                    $step3_style = 'background:#D1FAE5; color:#065F46;';
                    $step4_style = 'background:var(--primary); color:#fff;';
                    $step3_icon = 'fa-check-circle';
                    $step4_icon = 'fa-paper-plane';
                } else {
                    // Biodata belum lengkap
                    $step3_style = 'background:var(--primary); color:#fff;';
                    $step4_style = 'background:#E5E7EB; color:#6B7280;';
                    $step3_icon = 'fa-id-card';
                    $step4_icon = 'fa-paper-plane';
                }
            ?>
            <div style="display:flex; align-items:center; justify-content:center; gap:0.5rem; flex-wrap:wrap; max-width:750px; margin:0 auto;">
                <div style="display:flex; align-items:center; gap:0.4rem; <?= $step1_style; ?> padding:0.4rem 0.85rem; border-radius:50px; font-size:0.8rem; font-weight:600;">
                    <i class="fas fa-check-circle" style="font-size:0.75rem;"></i> 1. Buat Akun
                </div>
                <i class="fas fa-chevron-right" style="color:#D1D5DB; font-size:0.65rem;"></i>
                <div style="display:flex; align-items:center; gap:0.4rem; <?= $step2_style; ?> padding:0.4rem 0.85rem; border-radius:50px; font-size:0.8rem; font-weight:600;">
                    <i class="fas fa-check-circle" style="font-size:0.75rem;"></i> 2. Login
                </div>
                <i class="fas fa-chevron-right" style="color:#D1D5DB; font-size:0.65rem;"></i>
                <div style="display:flex; align-items:center; gap:0.4rem; <?= $step3_style; ?> padding:0.4rem 0.85rem; border-radius:50px; font-size:0.8rem; font-weight:600;">
                    <i class="fas <?= $step3_icon; ?>" style="font-size:0.75rem;"></i> 3. Biodata
                </div>
                <i class="fas fa-chevron-right" style="color:#D1D5DB; font-size:0.65rem;"></i>
                <div style="display:flex; align-items:center; gap:0.4rem; <?= $step4_style; ?> padding:0.4rem 0.85rem; border-radius:50px; font-size:0.8rem; font-weight:600;">
                    <i class="fas <?= $step4_icon; ?>" style="font-size:0.75rem;"></i> 4. Daftar Organisasi
                </div>
            </div>
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

            <?php if(!$is_complete): ?>
                <!-- ALERT BIODATA BELUM LENGKAP -->
                <div style="background:#FEF3C7; color:#92400E; padding:1.25rem 1.5rem; border-radius:12px; margin-bottom:2rem; border:1px solid #FCD34D; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        <i class="fas fa-exclamation-triangle" style="font-size:1.5rem; color:#D97706;"></i>
                        <div>
                            <strong style="display:block; font-size:1.05rem; margin-bottom:0.15rem;">Silakan lengkapi biodata terlebih dahulu sebelum melakukan pendaftaran organisasi.</strong>
                            <span style="font-size:0.875rem;">Beberapa data penting seperti foto profil, NIM, prodi, dan alamat belum terisi.</span>
                        </div>
                    </div>
                    <a href="<?= base_url('user/biodata'); ?>" class="btn btn-warning btn-sm" style="background:#D97706; border-color:#D97706; color:#fff;">
                        <i class="fas fa-edit me-1"></i> Lengkapi Biodata Sekarang
                    </a>
                </div>
            <?php endif; ?>

            <div class="user-dashboard-grid">
                
                <!-- KOLOM KIRI: STATUS & AKSI -->
                <div>
                    <!-- CARD STATUS KELENGKAPAN -->
                    <div style="background:#fff; padding:1.5rem; border-radius:16px; border:1px solid #E5E7EB; box-shadow:0 2px 8px rgba(0,0,0,0.04); margin-bottom:1.5rem;">
                        <h3 style="font-size:1.1rem; font-weight:700; color:var(--text-dark); margin-bottom:1rem; border-bottom:1px solid #F3F4F6; padding-bottom:0.75rem;">
                            Status Akun & Biodata
                        </h3>
                        
                        <div style="margin-bottom:1rem; display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:0.9rem; color:var(--gray);">Status Biodata:</span>
                            <?php if($is_complete): ?>
                                <span style="background:#D1FAE5; color:#065F46; padding:0.3rem 0.75rem; border-radius:50px; font-size:0.825rem; font-weight:600; display:inline-flex; align-items:center; gap:0.3rem;">
                                    <i class="fas fa-check-circle"></i> Lengkap
                                </span>
                            <?php else: ?>
                                <span style="background:#FEF3C7; color:#92400E; padding:0.3rem 0.75rem; border-radius:50px; font-size:0.825rem; font-weight:600; display:inline-flex; align-items:center; gap:0.3rem;">
                                    <i class="fas fa-exclamation-triangle"></i> Belum Lengkap
                                </span>
                            <?php endif; ?>
                        </div>

                        <div style="margin-bottom:1.5rem; display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:0.9rem; color:var(--gray);">Status Pendaftaran:</span>
                            <?php if($applicant): ?>
                                <?php
                                    $status_bg = '#E0F2FE'; $status_fg = '#0369A1';
                                    if($applicant->status == 'Lolos') { $status_bg = '#D1FAE5'; $status_fg = '#065F46'; }
                                    else if($applicant->status == 'Tidak Lolos') { $status_bg = '#FEE2E2'; $status_fg = '#991B1B'; }
                                    else if($applicant->status == 'Interview') { $status_bg = '#FEF3C7'; $status_fg = '#92400E'; }
                                ?>
                                <span style="background:<?= $status_bg; ?>; color:<?= $status_fg; ?>; padding:0.3rem 0.75rem; border-radius:50px; font-size:0.825rem; font-weight:600;">
                                    <?= htmlspecialchars($applicant->status); ?>
                                </span>
                            <?php else: ?>
                                <span style="background:#F3F4F6; color:#6B7280; padding:0.3rem 0.75rem; border-radius:50px; font-size:0.825rem; font-weight:600;">
                                    Belum Mendaftar
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- TOMBOL AKSI DAFTAR ORGANISASI -->
                        <?php if($applicant): ?>
                            <button class="btn btn-outline" style="width:100%; cursor:not-allowed; opacity:0.75; margin-bottom:0.75rem;" disabled>
                                <i class="fas fa-check-circle me-1"></i> Sudah Mendaftar Organisasi
                            </button>
                            <a href="<?= base_url('pendaftaran/pdf/' . $applicant->registration_code); ?>" class="btn btn-primary btn-sm" style="width:100%; text-align:center;">
                                <i class="fas fa-file-pdf me-1"></i> Download Bukti Pendaftaran (PDF)
                            </a>
                        <?php elseif(!$is_complete): ?>
                            <div style="position:relative;">
                                <button class="btn btn-primary" style="width:100%; cursor:not-allowed; opacity:0.6; margin-bottom:0.5rem;" disabled title="Lengkapi biodata terlebih dahulu">
                                    <i class="fas fa-paper-plane me-1"></i> Daftar Organisasi
                                </button>
                                <small style="display:block; text-align:center; color:#DC2626; font-size:0.8rem;">
                                    <i class="fas fa-lock me-1"></i> Tombol terkunci hingga biodata dilengkapi.
                                </small>
                            </div>
                        <?php else: ?>
                            <a href="<?= base_url('pendaftaran'); ?>" class="btn btn-primary btn-lg" style="width:100%; text-align:center;">
                                <i class="fas fa-paper-plane me-1"></i> Isi Form Pendaftaran Organisasi
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- CARD QUICK ACTION -->
                    <div style="background:#fff; padding:1.5rem; border-radius:16px; border:1px solid #E5E7EB; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                        <h4 style="font-weight:700; font-size:0.95rem; margin-bottom:0.75rem; color:var(--text-dark);">Menu Navigasi Pengguna</h4>
                        <div style="display:flex; flex-direction:column; gap:0.5rem; margin-top:1rem;">
                            <a href="<?= base_url('user/biodata'); ?>" class="btn btn-outline btn-sm" style="width:100%; text-align:center;">
                                <i class="fas fa-edit me-1"></i> Edit / Lengkapi Biodata
                            </a>
                        </div>
                    </div>

                    <!-- CARD PENGAJUAN PROPOSAL -->
                    <div style="background:#fff; padding:1.5rem; border-radius:16px; border:1px solid #E5E7EB; box-shadow:0 2px 8px rgba(0,0,0,0.04); margin-bottom:1.5rem;">
                        <h3 style="font-size:1.1rem; font-weight:700; color:var(--text-dark); margin-bottom:0.5rem;">
                            <i class="fas fa-file-pdf me-2" style="color:var(--primary);"></i> Pengajuan Proposal
                        </h3>
                        <p style="font-size:0.85rem; color:var(--gray); margin-bottom:1rem; line-height:1.4;">
                            Kirimkan proposal pelaksanaan program kerja atau kegiatan organisasi Anda dalam format PDF.
                        </p>
                        <a href="<?= base_url('pengajuan-proposal'); ?>" class="btn btn-primary btn-sm" style="width:100%; text-align:center;">
                            <i class="fas fa-paper-plane me-1"></i> Kelola & Ajukan Proposal
                        </a>
                    </div>
                    
                    <div style="background:#fff; padding:1.5rem; border-radius:16px; border:1px solid #E5E7EB; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                        <div style="display:flex; flex-direction:column; gap:0.5rem;">
                            <a href="<?= base_url('auth/logout'); ?>" class="btn btn-danger btn-sm" style="justify-content:flex-start; background:#DC2626; color:#fff;">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: BIODATA & DETAIL PENDAFTARAN -->
                <div>
                    <!-- RIWAYAT PENDAFTARAN (Jika Ada) -->
                    <?php if($applicant): ?>
                        <div style="background:#fff; padding:1.75rem; border-radius:16px; border:1px solid #E5E7EB; box-shadow:0 2px 8px rgba(0,0,0,0.04); margin-bottom:1.5rem;">
                            <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #E5E7EB; padding-bottom:0.75rem; margin-bottom:1rem;">
                                <h3 style="font-size:1.2rem; font-weight:700; color:var(--text-dark); margin:0;">
                                    <i class="fas fa-clipboard-check text-primary me-2" style="color:var(--primary);"></i> Pendaftaran Organisasi
                                </h3>
                                <span style="font-size:0.85rem; font-weight:600; color:var(--primary); background:rgba(122,31,43,0.08); padding:0.25rem 0.6rem; border-radius:6px;">
                                    <?= htmlspecialchars($applicant->registration_code); ?>
                                </span>
                            </div>

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; font-size:0.9rem;">
                                <div>
                                    <span style="color:var(--gray); display:block; font-size:0.8rem;">Pilihan Divisi:</span>
                                    <strong style="color:var(--text-dark);"><?= htmlspecialchars($applicant->division_name); ?></strong>
                                </div>
                                <div>
                                    <span style="color:var(--gray); display:block; font-size:0.8rem;">Tanggal Mendaftar:</span>
                                    <strong style="color:var(--text-dark);"><?= date('d F Y - H:i', strtotime($applicant->created_at)); ?> WIB</strong>
                                </div>
                                <div>
                                    <span style="color:var(--gray); display:block; font-size:0.8rem;">Status Verifikasi Admin:</span>
                                    <strong style="color:var(--primary);"><?= htmlspecialchars($applicant->status); ?></strong>
                                </div>
                                <div>
                                    <span style="color:var(--gray); display:block; font-size:0.8rem;">Unduh PDF Bukti:</span>
                                    <a href="<?= base_url('pendaftaran/pdf/' . $applicant->registration_code); ?>" style="color:var(--primary); text-decoration:underline; font-weight:600;">
                                        <i class="fas fa-file-pdf me-1"></i> Bukti_Pendaftaran_<?= $applicant->registration_code; ?>.pdf
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- PROFILE DETAIL BIODATA -->
                    <div style="background:#fff; padding:1.75rem; border-radius:16px; border:1px solid #E5E7EB; box-shadow:0 2px 8px rgba(0,0,0,0.04); margin-bottom:1.5rem;">
                        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #E5E7EB; padding-bottom:0.75rem; margin-bottom:1.25rem;">
                            <h3 style="font-size:1.2rem; font-weight:700; color:var(--text-dark); margin:0;">
                                <i class="fas fa-id-card me-2" style="color:var(--primary);"></i> Rincian Biodata
                            </h3>
                            <a href="<?= base_url('user/biodata'); ?>" class="btn btn-outline btn-sm">
                                <i class="fas fa-edit me-1"></i> Edit Biodata
                            </a>
                        </div>

                        <div style="display:flex; gap:1.5rem; align-items:start; margin-bottom:1.5rem;">
                            <div style="width:110px; height:110px; border-radius:12px; background:#F3F4F6; overflow:hidden; border:2px solid var(--primary-light); flex-shrink:0; display:flex; align-items:center; justify-content:center;">
                                <?php if(!empty($user->photo) && file_exists('./uploads/photos/' . $user->photo)): ?>
                                    <img src="<?= base_url('uploads/photos/' . $user->photo); ?>" alt="Foto Profil" style="width:100%; height:100%; object-fit:cover;">
                                <?php else: ?>
                                    <i class="fas fa-user-circle" style="font-size:3.5rem; color:#9CA3AF;"></i>
                                <?php endif; ?>
                            </div>
                            
                            <div style="flex-grow:1; display:grid; grid-template-columns:1fr 1fr; gap:0.75rem; font-size:0.9rem;">
                                <div>
                                    <span style="color:var(--gray); font-size:0.8rem; display:block;">Nama Lengkap:</span>
                                    <strong style="color:var(--text-dark);"><?= htmlspecialchars($user->full_name); ?></strong>
                                </div>
                                <div>
                                    <span style="color:var(--gray); font-size:0.8rem; display:block;">NIM:</span>
                                    <strong style="color:var(--text-dark);"><?= $user->nim ? htmlspecialchars($user->nim) : '-'; ?></strong>
                                </div>
                                <div>
                                    <span style="color:var(--gray); font-size:0.8rem; display:block;">Email Kampus FICT:</span>
                                    <strong style="color:var(--text-dark);"><?= htmlspecialchars($user->email); ?></strong>
                                </div>
                                <div>
                                    <span style="color:var(--gray); font-size:0.8rem; display:block;">No. HP / WA:</span>
                                    <strong style="color:var(--text-dark);"><?= $user->phone ? htmlspecialchars($user->phone) : '-'; ?></strong>
                                </div>
                                <div>
                                    <span style="color:var(--gray); font-size:0.8rem; display:block;">Program Studi:</span>
                                    <strong style="color:var(--text-dark);"><?= $user->study_program ? htmlspecialchars($user->study_program) : '-'; ?></strong>
                                </div>
                                <div>
                                    <span style="color:var(--gray); font-size:0.8rem; display:block;">Kelas:</span>
                                    <strong style="color:var(--text-dark);"><?= $user->class_name ? htmlspecialchars($user->class_name) : '-'; ?></strong>
                                </div>
                            </div>
                        </div>

                        <div style="border-top:1px solid #F3F4F6; padding-top:1rem; display:grid; grid-template-columns:1fr 1fr; gap:1rem; font-size:0.875rem;">
                            <div>
                                <span style="color:var(--gray); font-size:0.8rem; display:block;">Tempat, Tanggal Lahir:</span>
                                <strong style="color:var(--text-dark);">
                                    <?= ($user->birth_place && $user->birth_date) ? htmlspecialchars($user->birth_place) . ', ' . date('d F Y', strtotime($user->birth_date)) : '-'; ?>
                                </strong>
                            </div>
                            <div>
                                <span style="color:var(--gray); font-size:0.8rem; display:block;">Jenis Kelamin:</span>
                                <strong style="color:var(--text-dark);"><?= $user->gender ? htmlspecialchars($user->gender) : '-'; ?></strong>
                            </div>
                            <div style="grid-column: span 2;">
                                <span style="color:var(--gray); font-size:0.8rem; display:block;">Alamat Lengkap:</span>
                                <span style="color:var(--text-dark);"><?= $user->address ? nl2br(htmlspecialchars($user->address)) : '-'; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- PENGUMUMAN & INFORMASI REKRUTMEN -->
                    <div style="background:#fff; padding:1.75rem; border-radius:16px; border:1px solid #E5E7EB; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                        <h3 style="font-size:1.15rem; font-weight:700; color:var(--text-dark); margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem;">
                            <i class="fas fa-bullhorn" style="color:var(--primary);"></i> Pengumuman & Informasi Rekrutmen
                        </h3>
                        <div style="background:#FAF8F8; padding:1.25rem; border-radius:12px; border-left:4px solid var(--primary);">
                            <h4 style="font-size:0.95rem; font-weight:700; color:var(--primary); margin-bottom:0.35rem;">
                                Informasi Seleksi Calon Anggota PR FICT 2026
                            </h4>
                            <p style="font-size:0.875rem; color:var(--text-body); line-height:1.6; margin-bottom:0.75rem;">
                                Seluruh mahasiswa Fakultas FICT yang telah melengkapi biodata dan mendaftar organisasi akan mengikuti tahapan verifikasi berkas admin & wawancara. Silakan periksa status pendaftaran Anda secara berkala di dashboard ini.
                            </p>
                            <?php if($applicant): ?>
                                <a href="<?= base_url('pendaftaran/pdf/' . $applicant->registration_code); ?>" class="btn btn-outline btn-sm">
                                    <i class="fas fa-file-pdf me-1"></i> Download Berkas Pendaftaran (PDF)
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

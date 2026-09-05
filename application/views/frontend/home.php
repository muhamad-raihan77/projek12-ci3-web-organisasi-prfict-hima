    <!-- Hero Section -->
    <section id="beranda" class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <div class="hero-badge">
                        OPEN RECRUITMENT 2026
                    </div>
                    <h1>
                        BE THE VOICE.<br>
                        <span>BE THE CHANGE.</span>
                    </h1>
                    <p>Bergabunglah bersama Program Representative FICT dan jadilah bagian dari mahasiswa yang aktif, kolaboratif, dan berkontribusi dalam membangun lingkungan kampus yang lebih baik.</p>
                    <div class="hero-buttons">
                        <a href="<?= base_url('pendaftaran'); ?>" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i> DAFTAR SEKARANG
                        </a>
                        <a href="<?= base_url('cek-status'); ?>" class="btn btn-outline btn-lg">
                            <i class="fas fa-search me-2"></i> CEK STATUS PENDAFTARAN
                        </a>
                    </div>
                </div>
                
                <div class="hero-visual">
                    <div class="hero-illustration">
                        <div class="hero-shapes">
                            <div class="hero-shape hero-shape-1"></div>
                            <div class="hero-shape hero-shape-2"></div>
                            <div class="hero-shape hero-shape-3"></div>
                            <div class="hero-center-emblem">
                                <img src="<?= base_url('assets/img/logo.png'); ?>" alt="PR FICT Logo" class="hero-logo-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Tentang -->
    <section id="tentang">
        <div class="container">
            <h2 class="section-title">Tentang Program Representative FICT</h2>
            <p class="section-subtitle">Wadah aspirasi dan pengembangan potensi bagi seluruh mahasiswa Fakultas Information and Computer Technology.</p>
            
            <div class="about-content">
                <div class="about-text">
                    <p>Program Representative FICT merupakan wadah bagi mahasiswa untuk berkontribusi, berkolaborasi, dan menjadi representasi positif dalam lingkungan Fakultas Information and Computer Technology Horizon University Indonesia.</p>
                    <p>Kami berdedikasi menciptakan sinergi antar sesama mahasiswa, program studi, dan fakultas demi terciptanya akademisi yang unggul, berkarakter, dan berdaya saing global.</p>
                </div>
                
                <div class="value-cards">
                    <div class="value-card">
                        <div class="icon"><i class="fas fa-user-tie"></i></div>
                        <h4>Leadership</h4>
                        <p>Membentuk jiwa kepemimpinan yang tangguh dan bertanggung jawab.</p>
                    </div>
                    <div class="value-card">
                        <div class="icon"><i class="fas fa-handshake"></i></div>
                        <h4>Collaboration</h4>
                        <p>Membangun kerja sama yang solid dan saling mendukung.</p>
                    </div>
                    <div class="value-card">
                        <div class="icon"><i class="fas fa-comments"></i></div>
                        <h4>Communication</h4>
                        <p>Menjadi jembatan komunikasi dan penyalur aspirasi yang efektif.</p>
                    </div>
                    <div class="value-card">
                        <div class="icon"><i class="fas fa-chart-line"></i></div>
                        <h4>Growth</h4>
                        <p>Mendorong pertumbuhan soft skill dan hard skill berkelanjutan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Keuntungan -->
    <section>
        <div class="container">
            <h2 class="section-title">Kenapa Bergabung?</h2>
            <p class="section-subtitle">Dapatkan pengalaman berharga dan berbagai manfaat selama menjadi bagian dari PR FICT.</p>
            
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="icon"><i class="fas fa-award"></i></div>
                    <h4>Mengembangkan Leadership</h4>
                    <p>Latih kemampuan memimpin, mengambil keputusan, dan mengelola tim dalam proyek nyata.</p>
                </div>
                <div class="benefit-card">
                    <div class="icon"><i class="fas fa-network-wired"></i></div>
                    <h4>Memperluas Networking</h4>
                    <p>Bangun koneksi luas dengan sesama mahasiswa, alumni, hingga profesional di bidang IT.</p>
                </div>
                <div class="benefit-card">
                    <div class="icon"><i class="fas fa-brain"></i></div>
                    <h4>Meningkatkan Soft Skill</h4>
                    <p>Asah kemampuan komunikasi, problem solving, public speaking, dan manajemen waktu.</p>
                </div>
                <div class="benefit-card">
                    <div class="icon"><i class="fas fa-briefcase"></i></div>
                    <h4>Pengalaman Organisasi</h4>
                    <p>Perkaya CV Anda dengan portofolio kegiatan dan pengalaman organisasi kampus yang diakui.</p>
                </div>
                <div class="benefit-card">
                    <div class="icon"><i class="fas fa-heart"></i></div>
                    <h4>Berkontribusi untuk FICT</h4>
                    <p>Ikut serta secara langsung dalam memajukan lingkungan fakultas dan mahasiswa FICT.</p>
                </div>
                <div class="benefit-card">
                    <div class="icon"><i class="fas fa-rocket"></i></div>
                    <h4>Mengembangkan Potensi Diri</h4>
                    <p>Temukan bakat dan minat baru melalui berbagai divisi dan program kerja yang dinamis.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Struktur Organisasi -->
    <section id="struktur-organisasi" class="org-section">
        <div class="org-decoration org-decoration-1"></div>
        <div class="org-decoration org-decoration-2"></div>
        <div class="org-decoration org-decoration-3"></div>

        <div class="container">
            <h2 class="section-title org-animate" data-animate="fade-up">Struktur <span class="text-maroon">Organisasi</span></h2>
            <p class="org-kabinet-label org-animate" data-animate="fade-up">PR FICT KABINET ADHIYAKHSA</p>
            <p class="section-subtitle org-animate" data-animate="fade-up">Di balik setiap langkah dan program, terdapat tim yang berkomitmen untuk berkolaborasi, bertumbuh, dan memberikan kontribusi terbaik bagi FICT.</p>
            <p class="org-meet-team org-animate" data-animate="fade-up">Meet The Team</p>

            <?php if(!empty($org_members)):
                // Helper to safely get the photo URL on both Windows and Linux environments
                $get_member_photo = function($photo_filename) {
                    if (empty($photo_filename)) return false;
                    $full_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'organization' . DIRECTORY_SEPARATOR . $photo_filename;
                    $full_path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $full_path);
                    if (file_exists($full_path)) {
                        return base_url('uploads/organization/' . $photo_filename);
                    }
                    return false;
                };

                // Group members by hierarchy
                $ketua = null;
                $wakil = null;
                $sekretaris = [];
                $bendahara = [];
                $komdigi = null;
                $humas = null;

                foreach($org_members as $m) {
                    $pos = strtolower($m->position);
                    $div = strtolower($m->division);
                    if ($pos === 'ketua') {
                        $ketua = $m;
                    } elseif ($pos === 'wakil ketua') {
                        $wakil = $m;
                    } elseif ($div === 'sekretariat') {
                        $sekretaris[] = $m;
                    } elseif ($div === 'keuangan') {
                        $bendahara[] = $m;
                    } elseif ($pos === 'komdigi') {
                        $komdigi = $m;
                    } elseif ($pos === 'humas') {
                        $humas = $m;
                    }
                }
            ?>

            <div class="org-tree">
                
                <!-- Ketua -->
                <?php if($ketua): 
                    $ketua_photo = $get_member_photo($ketua->photo);
                    $ketua_initials = strtoupper(substr($ketua->name, 0, 1) . (strpos($ketua->name, ' ') !== false ? substr($ketua->name, strpos($ketua->name, ' ')+1, 1) : ''));
                ?>
                <div class="org-node org-animate" data-animate="fade-up">
                    <div class="org-card org-card-leader" data-member-id="<?= $ketua->id; ?>" onclick="openOrgModal(this)">
                        <div class="org-leader-label">LEADERSHIP</div>
                        <div class="org-card-photo">
                            <?php if($ketua_photo): ?>
                                <img src="<?= $ketua_photo; ?>" alt="Foto M. Raihan Ketua Program Representative FICT">
                            <?php else: ?>
                                <div class="org-avatar org-avatar-leader"><?= $ketua_initials; ?></div>
                            <?php endif; ?>
                        </div>
                        <h3 class="org-card-name"><?= html_escape($ketua->name); ?></h3>
                        <p class="org-card-position"><?= html_escape($ketua->position); ?></p>
                        <?php if($ketua->motto): ?>
                        <div class="org-card-motto">
                            <span class="org-quote-mark">&ldquo;</span>
                            <p><?= html_escape($ketua->motto); ?></p>
                        </div>
                        <?php endif; ?>
                        <!-- Hidden data for modal -->
                        <div class="org-card-data" style="display:none;"
                             data-name="<?= html_escape($ketua->name); ?>"
                             data-position="<?= html_escape($ketua->position); ?>"
                             data-division="<?= html_escape($ketua->division); ?>"
                             data-motto="<?= html_escape($ketua->motto ?? ''); ?>"
                             data-description="<?= html_escape($ketua->description ?? ''); ?>"
                             data-instagram="<?= html_escape($ketua->social_instagram ?? ''); ?>"
                             data-linkedin="<?= html_escape($ketua->social_linkedin ?? ''); ?>"
                             data-photo="<?= $ketua_photo ?: ''; ?>"
                             data-initials="<?= $ketua_initials; ?>"
                        ></div>
                    </div>
                    <div class="org-line-down"></div>
                </div>
                <?php endif; ?>

                <!-- Wakil Ketua -->
                <?php if($wakil): 
                    $wakil_photo = $get_member_photo($wakil->photo);
                    $wakil_initials = strtoupper(substr($wakil->name, 0, 1) . (strpos($wakil->name, ' ') !== false ? substr($wakil->name, strpos($wakil->name, ' ')+1, 1) : ''));
                ?>
                <div class="org-node org-animate" data-animate="fade-up">
                    <div class="org-card" data-member-id="<?= $wakil->id; ?>" onclick="openOrgModal(this)">
                        <div class="org-card-photo">
                            <?php if($wakil_photo): ?>
                                <img src="<?= $wakil_photo; ?>" alt="Foto Alisa Wakil Ketua Program Representative FICT">
                            <?php else: ?>
                                <div class="org-avatar"><?= $wakil_initials; ?></div>
                            <?php endif; ?>
                        </div>
                        <h3 class="org-card-name"><?= html_escape($wakil->name); ?></h3>
                        <p class="org-card-position"><?= html_escape($wakil->position); ?></p>
                        <div class="org-card-data" style="display:none;"
                             data-name="<?= html_escape($wakil->name); ?>"
                             data-position="<?= html_escape($wakil->position); ?>"
                             data-division="<?= html_escape($wakil->division); ?>"
                             data-motto="<?= html_escape($wakil->motto ?? ''); ?>"
                             data-description="<?= html_escape($wakil->description ?? ''); ?>"
                             data-instagram="<?= html_escape($wakil->social_instagram ?? ''); ?>"
                             data-linkedin="<?= html_escape($wakil->social_linkedin ?? ''); ?>"
                             data-photo="<?= $wakil_photo ?: ''; ?>"
                             data-initials="<?= $wakil_initials; ?>"
                        ></div>
                    </div>
                    <div class="org-line-down"></div>
                </div>
                <?php endif; ?>

                <!-- Level 3: Sekretaris & Bendahara Split -->
                <?php if(!empty($sekretaris) || !empty($bendahara)): ?>
                <div class="org-split-row org-animate" data-animate="fade-up">
                    <div class="org-split-horizontal"></div>
                    
                    <!-- Left: Sekretaris -->
                    <?php if(!empty($sekretaris)): ?>
                    <div class="org-split-col">
                        <div class="org-line-down-short"></div>
                        <div class="org-branch-title">SEKRETARIS</div>
                        <div class="org-line-down-short"></div>
                        <div class="org-subsplit-row">
                            <div class="org-subsplit-horizontal"></div>
                            
                            <?php foreach($sekretaris as $s): 
                                $s_photo = $get_member_photo($s->photo);
                                $s_initials = strtoupper(substr($s->name, 0, 1) . (strpos($s->name, ' ') !== false ? substr($s->name, strpos($s->name, ' ')+1, 1) : ''));
                            ?>
                            <div class="org-subsplit-col">
                                <div class="org-line-down-short"></div>
                                <div class="org-card org-card-sm" data-member-id="<?= $s->id; ?>" onclick="openOrgModal(this)">
                                    <div class="org-card-photo">
                                        <?php if($s_photo): ?>
                                            <img src="<?= $s_photo; ?>" alt="Foto <?= html_escape($s->name); ?> <?= html_escape($s->position); ?> Program Representative FICT">
                                        <?php else: ?>
                                            <div class="org-avatar"><?= $s_initials; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <h3 class="org-card-name"><?= html_escape($s->name); ?></h3>
                                    <p class="org-card-position"><?= html_escape($s->position); ?></p>
                                    <div class="org-card-data" style="display:none;"
                                         data-name="<?= html_escape($s->name); ?>"
                                         data-position="<?= html_escape($s->position); ?>"
                                         data-division="<?= html_escape($s->division); ?>"
                                         data-motto="<?= html_escape($s->motto ?? ''); ?>"
                                         data-description="<?= html_escape($s->description ?? ''); ?>"
                                         data-instagram="<?= html_escape($s->social_instagram ?? ''); ?>"
                                         data-linkedin="<?= html_escape($s->social_linkedin ?? ''); ?>"
                                         data-photo="<?= $s_photo ?: ''; ?>"
                                         data-initials="<?= $s_initials; ?>"
                                    ></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Bendahara Column -->
                    <?php if(!empty($bendahara)): ?>
                    <div class="org-split-col">
                        <div class="org-line-down-short"></div>
                        <div class="org-branch-title">BENDAHARA</div>
                        <div class="org-line-down-short"></div>
                        <div class="org-subsplit-row">
                            <div class="org-subsplit-horizontal"></div>
                            
                            <?php foreach($bendahara as $b): 
                                $b_photo = $get_member_photo($b->photo);
                                $b_initials = strtoupper(substr($b->name, 0, 1) . (strpos($b->name, ' ') !== false ? substr($b->name, strpos($b->name, ' ')+1, 1) : ''));
                            ?>
                            <div class="org-subsplit-col">
                                <div class="org-line-down-short"></div>
                                <div class="org-card org-card-sm" data-member-id="<?= $b->id; ?>" onclick="openOrgModal(this)">
                                    <div class="org-card-photo">
                                        <?php if($b_photo): ?>
                                            <img src="<?= $b_photo; ?>" alt="Foto <?= html_escape($b->name); ?> <?= html_escape($b->position); ?> Program Representative FICT">
                                        <?php else: ?>
                                            <div class="org-avatar"><?= $b_initials; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <h3 class="org-card-name"><?= html_escape($b->name); ?></h3>
                                    <p class="org-card-position"><?= html_escape($b->position); ?></p>
                                    <div class="org-card-data" style="display:none;"
                                         data-name="<?= html_escape($b->name); ?>"
                                         data-position="<?= html_escape($b->position); ?>"
                                         data-division="<?= html_escape($b->division); ?>"
                                         data-motto="<?= html_escape($b->motto ?? ''); ?>"
                                         data-description="<?= html_escape($b->description ?? ''); ?>"
                                         data-instagram="<?= html_escape($b->social_instagram ?? ''); ?>"
                                         data-linkedin="<?= html_escape($b->social_linkedin ?? ''); ?>"
                                         data-photo="<?= $b_photo ?: ''; ?>"
                                         data-initials="<?= $b_initials; ?>"
                                    ></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
                <?php endif; ?>

                <!-- Spine Spacer Line -->
                <?php if($komdigi || $humas): ?>
                <div class="org-connector-spine org-animate" data-animate="fade-in"></div>
                <?php endif; ?>

                <!-- Split 2: Komdigi & Humas -->
                <?php if($komdigi || $humas): ?>
                <div class="org-split-row org-animate" data-animate="fade-up">
                    <div class="org-split-horizontal"></div>
                    
                    <!-- Left: Komdigi -->
                    <?php if($komdigi): 
                        $kd_photo = $get_member_photo($komdigi->photo);
                        $kd_initials = strtoupper(substr($komdigi->name, 0, 1) . (strpos($komdigi->name, ' ') !== false ? substr($komdigi->name, strpos($komdigi->name, ' ')+1, 1) : ''));
                    ?>
                    <div class="org-split-col">
                        <div class="org-line-down-short"></div>
                        <div class="org-branch-title">KOMDIGI</div>
                        <div class="org-line-down-short"></div>
                        <div class="org-card org-card-sm" data-member-id="<?= $komdigi->id; ?>" onclick="openOrgModal(this)">
                            <div class="org-card-photo">
                                <?php if($kd_photo): ?>
                                    <img src="<?= $kd_photo; ?>" alt="Foto Paujan Komdigi Program Representative FICT">
                                <?php else: ?>
                                    <div class="org-avatar"><?= $kd_initials; ?></div>
                                <?php endif; ?>
                            </div>
                            <h3 class="org-card-name"><?= html_escape($komdigi->name); ?></h3>
                            <p class="org-card-position"><?= html_escape($komdigi->position); ?></p>
                            <div class="org-card-data" style="display:none;"
                                 data-name="<?= html_escape($komdigi->name); ?>"
                                 data-position="<?= html_escape($komdigi->position); ?>"
                                 data-division="<?= html_escape($komdigi->division); ?>"
                                 data-motto="<?= html_escape($komdigi->motto ?? ''); ?>"
                                 data-description="<?= html_escape($komdigi->description ?? ''); ?>"
                                 data-instagram="<?= html_escape($komdigi->social_instagram ?? ''); ?>"
                                 data-linkedin="<?= html_escape($komdigi->social_linkedin ?? ''); ?>"
                                 data-photo="<?= $kd_photo ?: ''; ?>"
                                 data-initials="<?= $kd_initials; ?>"
                            ></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Right: Humas -->
                    <?php if($humas): 
                        $hm_photo = $get_member_photo($humas->photo);
                        $hm_initials = strtoupper(substr($humas->name, 0, 1) . (strpos($humas->name, ' ') !== false ? substr($humas->name, strpos($humas->name, ' ')+1, 1) : ''));
                    ?>
                    <div class="org-split-col">
                        <div class="org-line-down-short"></div>
                        <div class="org-branch-title">HUMAS</div>
                        <div class="org-line-down-short"></div>
                        <div class="org-card org-card-sm" data-member-id="<?= $humas->id; ?>" onclick="openOrgModal(this)">
                            <div class="org-card-photo">
                                <?php if($hm_photo): ?>
                                    <img src="<?= $hm_photo; ?>" alt="Foto Puspa Humas Program Representative FICT">
                                <?php else: ?>
                                    <div class="org-avatar"><?= $hm_initials; ?></div>
                                <?php endif; ?>
                            </div>
                            <h3 class="org-card-name"><?= html_escape($humas->name); ?></h3>
                            <p class="org-card-position"><?= html_escape($humas->position); ?></p>
                            <div class="org-card-data" style="display:none;"
                                 data-name="<?= html_escape($humas->name); ?>"
                                 data-position="<?= html_escape($humas->position); ?>"
                                 data-division="<?= html_escape($humas->division); ?>"
                                 data-motto="<?= html_escape($humas->motto ?? ''); ?>"
                                 data-description="<?= html_escape($humas->description ?? ''); ?>"
                                 data-instagram="<?= html_escape($humas->social_instagram ?? ''); ?>"
                                 data-linkedin="<?= html_escape($humas->social_linkedin ?? ''); ?>"
                                 data-photo="<?= $hm_photo ?: ''; ?>"
                                 data-initials="<?= $hm_initials; ?>"
                            ></div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Organization Member Detail Modal -->
    <div class="org-modal-overlay" id="orgModalOverlay" onclick="closeOrgModal()">
        <div class="org-modal" onclick="event.stopPropagation()">
            <button class="org-modal-close" onclick="closeOrgModal()" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
            <div class="org-modal-body">
                <div class="org-modal-photo" id="orgModalPhoto"></div>
                <h3 class="org-modal-name" id="orgModalName"></h3>
                <p class="org-modal-position" id="orgModalPosition"></p>
                <div class="org-modal-motto" id="orgModalMotto" style="display:none;">
                    <span class="org-quote-mark">&ldquo;</span>
                    <p id="orgModalMottoText"></p>
                </div>
                <div class="org-modal-divider"></div>
                <p class="org-modal-description" id="orgModalDescription"></p>
                <div class="org-modal-socials" id="orgModalSocials"></div>
            </div>
        </div>
    </div>

    <!-- Section Divisi -->
    <section id="divisi">
        <div class="container">
            <h2 class="section-title">Pilihan Divisi</h2>
            <p class="section-subtitle">Pilih divisi yang paling sesuai dengan minat, keahlian, dan potensi yang ingin Anda kembangkan.</p>
            
            <div class="division-grid">
                <?php if(!empty($divisions)): ?>
                    <?php foreach($divisions as $div): ?>
                        <div class="division-card">
                            <div class="icon">
                                <i class="fas <?= $div->icon; ?>"></i>
                            </div>
                            <h4><?= html_escape($div->name); ?></h4>
                            <p><?= html_escape($div->description); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Section Persyaratan -->
    <section id="persyaratan">
        <div class="container">
            <h2 class="section-title">Persyaratan Pendaftaran</h2>
            <p class="section-subtitle">Pastikan Anda memenuhi syarat berikut sebelum melakukan pendaftaran.</p>
            
            <div class="requirements-list">
                <div class="requirement-item">
                    <div class="check"><i class="fas fa-check"></i></div>
                    <p>Mahasiswa aktif Horizon University Indonesia dari Fakultas Information and Computer Technology (FICT).</p>
                </div>
                <div class="requirement-item">
                    <div class="check"><i class="fas fa-check"></i></div>
                    <p>Memiliki komitmen tinggi untuk berorganisasi dan berkontribusi secara aktif.</p>
                </div>
                <div class="requirement-item">
                    <div class="check"><i class="fas fa-check"></i></div>
                    <p>Bersedia mengikuti seluruh tahapan proses seleksi Open Recruitment 2026.</p>
                </div>
                <div class="requirement-item">
                    <div class="check"><i class="fas fa-check"></i></div>
                    <p>Mampu bekerja sama dalam tim dan memiliki komunikasi yang baik.</p>
                </div>
                <div class="requirement-item">
                    <div class="check"><i class="fas fa-check"></i></div>
                    <p>Bertanggung jawab, disiplin, dan memiliki integritas tinggi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Timeline -->
    <section id="timeline">
        <div class="container">
            <h2 class="section-title">Timeline Rekrutmen</h2>
            <p class="section-subtitle">Catat tanggal-tanggal penting dalam alur pendaftaran anggota PR FICT 2026.</p>
            
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-number">01</div>
                    <div class="timeline-content">
                        <h4>Pendaftaran Dibuka</h4>
                        <p>Pengisian formulir pendaftaran secara online melalui website resmi PR FICT.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-number">02</div>
                    <div class="timeline-content">
                        <h4>Pengisian Formulir & Berkas</h4>
                        <p>Melengkapi data pribadi, alasan bergabung, pilihan divisi, dan upload berkas pendukung.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-number">03</div>
                    <div class="timeline-content">
                        <h4>Seleksi Administrasi</h4>
                        <p>Pemeriksaan dan verifikasi kelengkapan berkas pendaftaran oleh tim panitia.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-number">04</div>
                    <div class="timeline-content">
                        <h4>Interview / Wawancara</h4>
                        <p>Sesi wawancara tatap muka atau online untuk menilai komitmen dan kesesuaian divisi.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-number">05</div>
                    <div class="timeline-content">
                        <h4>Pengumuman Akhir</h4>
                        <p>Pengumuman kelulusan pendaftar yang dapat dicek langsung melalui fitur Cek Status.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section FAQ -->
    <section id="faq">
        <div class="container">
            <h2 class="section-title">Pertanyaan Umum (FAQ)</h2>
            <p class="section-subtitle">Temukan jawaban atas pertanyaan yang sering diajukan seputar Open Recruitment PR FICT.</p>
            
            <div class="faq-list">
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Siapa yang dapat mendaftar?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Seluruh mahasiswa aktif Horizon University Indonesia dari Fakultas Information and Computer Technology (FICT) semua semester yang memenuhi syarat dapat mendaftar.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Apakah wajib memiliki pengalaman organisasi sebelumnya?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Tidak wajib. Pengalaman organisasi menjadi nilai tambah, namun semangat belajar, komitmen, dan potensi diri Anda adalah fokus utama penilaian kami.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Apa saja divisi yang tersedia di PR FICT?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Divisi yang tersedia meliputi PSDM, Humas, Media & Kreatif, Acara, Kominfo, dan Advokasi. Rincian deskripsi tiap divisi dapat dilihat pada section Divisi di atas.
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Bagaimana cara mengetahui status pendaftaran saya?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Setelah mendaftar, Anda akan mendapatkan Kode Pendaftaran unik (misal: PRFICT-2026-0001). Masukkan kode tersebut pada halaman Cek Status Pendaftaran untuk melihat perkembangan seleksi Anda secara realtime.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        <span>Kapan hasil seleksi diumumkan?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Hasil seleksi akan diperbarui secara berkala sesuai timeline. Anda dapat memantau status pendaftaran secara langsung melalui website.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Siap Menjadi Bagian dari PR FICT?</h2>
            <p>Ambil bagian dalam perjalanan, berkembang bersama, dan berikan kontribusi terbaikmu untuk FICT Horizon University Indonesia.</p>
            <a href="<?= base_url('pendaftaran'); ?>" class="btn btn-white btn-lg">
                <i class="fas fa-paper-plane me-2"></i> DAFTAR SEKARANG
            </a>
        </div>
    </section>

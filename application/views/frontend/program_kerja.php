<!-- Header Page -->
<div class="page-header">
    <div class="container">
        <h1>Program Kerja</h1>
        <p>Daftar rencana dan realisasi kegiatan Program Representative FICT Horizon University Indonesia</p>
    </div>
</div>

<section style="padding: 3rem 0; background: var(--off-white); min-height: 70vh;">
    <div class="container">
        
        <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <a href="<?= base_url(); ?>" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
            </a>
            <div style="color: var(--gray); font-size: 0.9rem; font-weight: 500;">
                <i class="fas fa-tasks me-1" style="color: var(--primary);"></i> Total Program Kerja: <strong><?= !empty($programs) ? count($programs) : 0; ?></strong>
            </div>
        </div>

        <?php if (!empty($programs)): ?>
            <div class="proker-grid">
                <?php $no = 1; foreach ($programs as $p): ?>
                    <?php 
                        $status_class = 'status-belum';
                        $status_icon = 'fa-clock';
                        if ($p->status == 'Berjalan') {
                            $status_class = 'status-berjalan';
                            $status_icon = 'fa-spinner fa-spin';
                        } elseif ($p->status == 'Selesai') {
                            $status_class = 'status-selesai';
                            $status_icon = 'fa-check-circle';
                        }

                        $has_thumb = !empty($p->dokumentasi) && count($p->dokumentasi) > 0;
                        $thumb_url = $has_thumb ? base_url('uploads/program_dokumentasi/' . $p->dokumentasi[0]->file_name) : '';

                        // Prepare array for JSON modal
                        $modal_data = [
                            'no' => $no,
                            'nama_program' => $p->nama_program,
                            'divisi' => $p->divisi,
                            'activity' => $p->activity,
                            'target' => $p->target,
                            'pic' => $p->pic,
                            'status' => $p->status,
                            'status_class' => $status_class,
                            'dokumentasi' => []
                        ];

                        if (!empty($p->dokumentasi)) {
                            foreach ($p->dokumentasi as $doc) {
                                $modal_data['dokumentasi'][] = [
                                    'url' => base_url('uploads/program_dokumentasi/' . $doc->file_name),
                                    'caption' => $doc->caption ? $doc->caption : $p->nama_program
                                ];
                            }
                        }
                        $json_str = htmlspecialchars(json_encode($modal_data), ENT_QUOTES, 'UTF-8');
                    ?>
                    
                    <div class="proker-card" onclick='openDetailModal(<?= $json_str; ?>)'>
                        <div class="proker-card-thumb-box">
                            <?php if ($has_thumb): ?>
                                <img src="<?= $thumb_url; ?>" alt="<?= html_escape($p->nama_program); ?>" class="proker-card-thumb" loading="lazy">
                            <?php else: ?>
                                <div class="proker-card-thumb-placeholder">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                            <?php endif; ?>
                            <span class="badge-status <?= $status_class; ?> proker-status-badge">
                                <i class="fas <?= $status_icon; ?>" style="font-size: 0.7rem;"></i>
                                <?= html_escape($p->status); ?>
                            </span>
                        </div>

                        <div class="proker-card-body">
                            <div class="proker-divisi-tag">
                                <i class="fas fa-sitemap me-1"></i> <?= html_escape($p->divisi); ?>
                            </div>
                            <h3 class="proker-card-title"><?= html_escape($p->nama_program); ?></h3>
                        </div>

                        <div class="proker-card-footer">
                            <button type="button" class="btn btn-outline btn-sm w-100" onclick='event.stopPropagation(); openDetailModal(<?= $json_str; ?>)'>
                                <i class="fas fa-eye me-1"></i> Lihat Detail
                            </button>
                        </div>
                    </div>
                <?php $no++; endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-proker-box">
                <i class="fas fa-folder-open"></i>
                <h3>Belum Ada Program Kerja</h3>
                <p>Program kerja yang ditambahkan oleh Admin akan otomatis muncul di halaman ini.</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- Detail Modal -->
<div id="prokerDetailModal" class="proker-modal-overlay" onclick="closeDetailModal(event)">
    <div class="proker-modal-container">
        <div class="proker-modal-header">
            <div>
                <span id="detailNo" class="proker-detail-number">#1</span>
                <h3 id="detailNamaProgram" class="proker-modal-title">Nama Program</h3>
            </div>
            <button class="proker-modal-close" onclick="closeDetailModal(event)">&times;</button>
        </div>

        <div class="proker-modal-body">
            <!-- Grid info -->
            <div class="proker-info-grid">
                <div class="proker-info-item">
                    <label><i class="fas fa-sitemap me-1"></i> Divisi</label>
                    <span id="detailDivisi" class="info-val">-</span>
                </div>
                <div class="proker-info-item">
                    <label><i class="fas fa-user-tie me-1"></i> PIC (Person in Charge)</label>
                    <span id="detailPic" class="info-val">-</span>
                </div>
                <div class="proker-info-item">
                    <label><i class="fas fa-flag me-1"></i> Status</label>
                    <div>
                        <span id="detailStatusBadge" class="badge-status">-</span>
                    </div>
                </div>
            </div>

            <div class="proker-detail-section">
                <h4><i class="fas fa-list-check me-1"></i> Activity / Deskripsi Kegiatan</h4>
                <p id="detailActivity" class="proker-text-box">-</p>
            </div>

            <div class="proker-detail-section">
                <h4><i class="fas fa-bullseye me-1"></i> Target & Capaian</h4>
                <p id="detailTarget" class="proker-text-box">-</p>
            </div>

            <div class="proker-detail-section">
                <h4><i class="fas fa-images me-1"></i> Dokumentasi Kegiatan</h4>
                <div id="detailGalleryContainer">
                    <!-- Gallery rendered via JS -->
                </div>
            </div>
        </div>

        <div class="proker-modal-footer">
            <button class="btn btn-outline btn-sm" onclick="closeDetailModal(event)">Tutup</button>
        </div>
    </div>
</div>

<!-- Lightbox Modal for Enlarged Gallery Image -->
<div id="lightboxModal" class="lightbox-modal" onclick="closeLightbox(event)">
    <button class="lightbox-close" onclick="closeLightbox(event)">&times;</button>
    <img id="lightboxImg" src="" class="lightbox-content" alt="Dokumentasi Enlarged">
    <div id="lightboxCaption" class="lightbox-caption"></div>
</div>

<script>
function openDetailModal(data) {
    document.getElementById('detailNo').innerText = '#' + data.no;
    document.getElementById('detailNamaProgram').innerText = data.nama_program;
    document.getElementById('detailDivisi').innerText = data.divisi;
    document.getElementById('detailPic').innerText = data.pic;

    const statusBadge = document.getElementById('detailStatusBadge');
    statusBadge.className = 'badge-status ' + data.status_class;
    let iconClass = 'fa-clock';
    if (data.status === 'Berjalan') iconClass = 'fa-spinner fa-spin';
    else if (data.status === 'Selesai') iconClass = 'fa-check-circle';
    statusBadge.innerHTML = `<i class="fas ${iconClass}" style="font-size: 0.75rem;"></i> ${data.status}`;

    document.getElementById('detailActivity').innerText = data.activity ? data.activity : 'Tidak ada deskripsi activity.';
    document.getElementById('detailTarget').innerText = data.target ? data.target : 'Tidak ada target khusus.';

    const galleryBox = document.getElementById('detailGalleryContainer');
    if (data.dokumentasi && data.dokumentasi.length > 0) {
        let galleryHtml = '<div class="proker-gallery-grid">';
        data.dokumentasi.forEach((item) => {
            const escapedCaption = (item.caption || '').replace(/'/g, "\\'").replace(/"/g, '&quot;');
            galleryHtml += `
                <div class="proker-gallery-card" onclick="openLightbox('${item.url}', '${escapedCaption}')">
                    <img src="${item.url}" alt="Dokumentasi" loading="lazy">
                    <div class="gallery-card-overlay">
                        <i class="fas fa-search-plus"></i>
                    </div>
                </div>
            `;
        });
        galleryHtml += '</div>';
        galleryBox.innerHTML = galleryHtml;
    } else {
        galleryBox.innerHTML = '<div class="no-doc-alert"><i class="fas fa-info-circle me-1"></i> Belum ada foto dokumentasi kegiatan.</div>';
    }

    document.getElementById('prokerDetailModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDetailModal(e) {
    if (e.target.id === 'prokerDetailModal' || e.target.classList.contains('proker-modal-close') || (e.target.tagName === 'BUTTON' && e.target.innerText.includes('Tutup'))) {
        document.getElementById('prokerDetailModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

function openLightbox(src, caption) {
    const modal = document.getElementById('lightboxModal');
    const img = document.getElementById('lightboxImg');
    const cap = document.getElementById('lightboxCaption');
    img.src = src;
    cap.innerText = caption ? caption : '';
    modal.classList.add('active');
}

function closeLightbox(e) {
    if (e.target.id === 'lightboxModal' || e.target.classList.contains('lightbox-close')) {
        const modal = document.getElementById('lightboxModal');
        modal.classList.remove('active');
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const lightboxModal = document.getElementById('lightboxModal');
        const detailModal = document.getElementById('prokerDetailModal');
        if (lightboxModal && lightboxModal.classList.contains('active')) {
            lightboxModal.classList.remove('active');
        } else if (detailModal && detailModal.classList.contains('active')) {
            detailModal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }
});
</script>

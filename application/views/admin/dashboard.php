<!-- Flash Messages -->
<?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success mb-4">
        <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<!-- Stat Cards -->
<div class="stats-grid">
    <div class="stat-card total">
        <div class="info">
            <div class="number"><?= $stats->total; ?></div>
            <div class="label">Total Pendaftar</div>
        </div>
        <div class="icon">
            <i class="fas fa-users"></i>
        </div>
    </div>

    <div class="stat-card today">
        <div class="info">
            <div class="number"><?= $stats->today; ?></div>
            <div class="label">Hari Ini</div>
        </div>
        <div class="icon">
            <i class="fas fa-calendar-day"></i>
        </div>
    </div>

    <div class="stat-card menunggu">
        <div class="info">
            <div class="number"><?= $stats->menunggu + $stats->seleksi; ?></div>
            <div class="label">Dalam Seleksi</div>
        </div>
        <div class="icon">
            <i class="fas fa-hourglass-half"></i>
        </div>
    </div>

    <div class="stat-card lolos">
        <div class="info">
            <div class="number"><?= $stats->lolos; ?></div>
            <div class="label">Lolos</div>
        </div>
        <div class="icon">
            <i class="fas fa-user-check"></i>
        </div>
    </div>

    <div class="stat-card tidak">
        <div class="info">
            <div class="number"><?= $stats->tidak_lolos; ?></div>
            <div class="label">Tidak Lolos</div>
        </div>
        <div class="icon">
            <i class="fas fa-user-times"></i>
        </div>
    </div>
</div>

<!-- Program Kerja Stat Cards -->
<h3 style="font-size:1.05rem; font-weight:700; margin-bottom:1rem; color:var(--text-dark); display:flex; align-items:center; gap:0.5rem;">
    <i class="fas fa-tasks" style="color:var(--primary);"></i> Statistik Program Kerja
</h3>
<div class="stats-grid">
    <div class="stat-card proker-total">
        <div class="info">
            <div class="number"><?= isset($proker_stats) ? $proker_stats->total : 0; ?></div>
            <div class="label">Total Program Kerja</div>
        </div>
        <div class="icon">
            <i class="fas fa-clipboard-list"></i>
        </div>
    </div>

    <div class="stat-card proker-berjalan">
        <div class="info">
            <div class="number"><?= isset($proker_stats) ? $proker_stats->berjalan : 0; ?></div>
            <div class="label">Program Berjalan</div>
        </div>
        <div class="icon">
            <i class="fas fa-spinner"></i>
        </div>
    </div>

    <div class="stat-card proker-selesai">
        <div class="info">
            <div class="number"><?= isset($proker_stats) ? $proker_stats->selesai : 0; ?></div>
            <div class="label">Program Selesai</div>
        </div>
        <div class="icon">
            <i class="fas fa-check-double"></i>
        </div>
    </div>
</div>


<!-- Chart & Recent Applicants -->
<div class="admin-grid-1-1" style="margin-bottom:2rem;">
    <!-- Division Chart -->
    <div style="background:var(--white); padding:1.5rem; border-radius:var(--radius); border:1px solid var(--gray-light); box-shadow:0 1px 3px rgba(0,0,0,0.05);">
        <h3 style="font-size:1rem; font-weight:700; margin-bottom:1rem;">Jumlah Pendaftar per Divisi</h3>
        <div style="position:relative; height:250px;">
            <canvas id="divisionChart"></canvas>
        </div>
    </div>

    <!-- Status Overview -->
    <div style="background:var(--white); padding:1.5rem; border-radius:var(--radius); border:1px solid var(--gray-light); box-shadow:0 1px 3px rgba(0,0,0,0.05);">
        <h3 style="font-size:1rem; font-weight:700; margin-bottom:1rem;">Status Seleksi Overview</h3>
        <div style="position:relative; height:250px;">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

<!-- Recent Applicants Table -->
<div class="card-table">
    <div class="card-table-header">
        <h3>Pendaftar Terbaru</h3>
        <a href="<?= base_url('admin/pendaftar'); ?>" class="btn btn-outline btn-sm">Lihat Semua</a>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Divisi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($recent)): ?>
                    <?php foreach($recent as $r): ?>
                        <tr>
                            <td><strong><?= html_escape($r->registration_code); ?></strong></td>
                            <td><?= html_escape($r->full_name); ?></td>
                            <td><?= html_escape($r->nim); ?></td>
                            <td><?= html_escape($r->division_name); ?></td>
                            <td>
                                <?php 
                                    $badge_class = 'menunggu';
                                    if ($r->status == 'Seleksi Administrasi') $badge_class = 'seleksi';
                                    elseif ($r->status == 'Interview') $badge_class = 'interview';
                                    elseif ($r->status == 'Lolos') $badge_class = 'lolos';
                                    elseif ($r->status == 'Tidak Lolos') $badge_class = 'tidak-lolos';
                                ?>
                                <span class="status-badge <?= $badge_class; ?>">
                                    <?= html_escape($r->status); ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($r->created_at)); ?></td>
                            <td>
                                <a href="<?= base_url('admin/pendaftar/detail/' . $r->id); ?>" class="btn btn-primary btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center; color:var(--gray); padding:2rem;">Belum ada pendaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Division Chart
    const divLabels = [<?php foreach($division_stats as $ds) echo '"' . html_escape($ds->name) . '",'; ?>];
    const divData = [<?php foreach($division_stats as $ds) echo $ds->total . ','; ?>];

    new Chart(document.getElementById('divisionChart'), {
        type: 'bar',
        data: {
            labels: divLabels,
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: divData,
                backgroundColor: '#7A1F2B',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // Status Doughnut Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Seleksi Admin', 'Interview', 'Lolos', 'Tidak Lolos'],
            datasets: [{
                data: [
                    <?= $stats->menunggu; ?>,
                    <?= $stats->seleksi; ?>,
                    <?= $stats->interview; ?>,
                    <?= $stats->lolos; ?>,
                    <?= $stats->tidak_lolos; ?>
                ],
                backgroundColor: ['#D97706', '#2563EB', '#7A1F2B', '#059669', '#DC2626']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
</script>

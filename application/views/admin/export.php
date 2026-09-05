<div style="max-width:600px; margin:0 auto; background:var(--white); padding:2rem; border-radius:var(--radius); border:1px solid var(--gray-light); box-shadow:0 1px 3px rgba(0,0,0,0.05);">
    <h3 style="font-size:1.2rem; font-weight:800; margin-bottom:0.5rem; text-align:center;">Export Data Pendaftar</h3>
    <p style="color:var(--gray); font-size:0.88rem; text-align:center; margin-bottom:2rem;">Unduh data seluruh pendaftar ke dalam format file CSV / Excel spreadsheet.</p>

    <?= form_open('admin/export/csv', ['method' => 'GET']); ?>
        
        <div class="form-group mb-3">
            <label style="font-size:0.85rem;">Filter Divisi</label>
            <select name="division_id" class="form-control">
                <option value="">-- Semua Divisi --</option>
                <?php foreach($divisions as $d): ?>
                    <option value="<?= $d->id; ?>"><?= html_escape($d->name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-4">
            <label style="font-size:0.85rem;">Filter Status Seleksi</label>
            <select name="status" class="form-control">
                <option value="">-- Semua Status --</option>
                <?php foreach(['Menunggu', 'Seleksi Administrasi', 'Interview', 'Lolos', 'Tidak Lolos'] as $st): ?>
                    <option value="<?= $st; ?>"><?= $st; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100 btn-lg" style="width:100%;">
            <i class="fas fa-download me-2"></i> DOWNLOAD FILE CSV
        </button>

    <?= form_close(); ?>
</div>

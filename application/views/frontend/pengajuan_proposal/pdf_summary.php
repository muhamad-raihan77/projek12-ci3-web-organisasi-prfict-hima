<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Pengajuan Proposal - <?= html_escape($proposal->nama_program); ?></title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #1F1F1F;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header {
            border-bottom: 3px solid #7A1F2B;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header table {
            width: 100%;
        }
        .logo-text {
            font-size: 16px;
            font-weight: bold;
            color: #7A1F2B;
            text-transform: uppercase;
        }
        .sub-logo {
            font-size: 10px;
            color: #6B7280;
        }
        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #7A1F2B;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .data-table th, .data-table td {
            padding: 7px 10px;
            border: 1px solid #E5E7EB;
            text-align: left;
        }
        .data-table th {
            background-color: #7A1F2B;
            color: #FFFFFF;
            font-weight: bold;
            width: 28%;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #7A1F2B;
            margin-top: 15px;
            margin-bottom: 8px;
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 4px;
        }
        .box-text {
            background-color: #F9FAFB;
            border: 1px solid #E5E7EB;
            padding: 10px;
            border-radius: 4px;
            white-space: pre-line;
            font-size: 11px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            font-weight: bold;
            font-size: 10px;
            border-radius: 12px;
        }
        .footer-note {
            margin-top: 30px;
            font-size: 9px;
            color: #6B7280;
            border-top: 1px solid #E5E7EB;
            padding-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td style="width: 55px;">
                    <?php 
                        $logo_file = FCPATH . 'assets/img/logo.png';
                        $logo_src = file_exists($logo_file) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logo_file)) : '';
                    ?>
                    <?php if($logo_src): ?>
                        <img src="<?= $logo_src; ?>" style="width: 45px; height: 45px; border-radius: 50%;" alt="PR FICT Logo">
                    <?php endif; ?>
                </td>
                <td>
                    <div class="logo-text">PROGRAM REPRESENTATIVE FICT</div>
                    <div class="sub-logo">Horizon University Indonesia</div>
                </td>
                <td style="text-align: right; font-size: 10px; color: #6B7280;">
                    Dicetak pada: <?= date('d/m/Y H:i'); ?> WIB
                </td>
            </tr>
        </table>
    </div>

    <div class="title">
        LEMBAR PENGAJUAN PROPOSAL PROGRAM KERJA
    </div>

    <table class="data-table">
        <tr>
            <th>Nama Program / Kegiatan</th>
            <td><strong><?= html_escape($proposal->nama_program); ?></strong></td>
        </tr>
        <tr>
            <th>Divisi Penyelenggara</th>
            <td><?= html_escape($proposal->divisi); ?></td>
        </tr>
        <tr>
            <th>PIC / Penanggung Jawab</th>
            <td><?= html_escape($proposal->pic); ?></td>
        </tr>
        <tr>
            <th>Pemohon / Pengaju</th>
            <td><?= html_escape(isset($proposal->student_name) ? $proposal->student_name : '-'); ?> (<?= html_escape(isset($proposal->student_email) ? $proposal->student_email : '-'); ?>)</td>
        </tr>
        <tr>
            <th>Tanggal Pelaksanaan</th>
            <td><?= date('d F Y', strtotime($proposal->tanggal_pelaksanaan)); ?></td>
        </tr>
        <tr>
            <th>Lokasi Kegiatan</th>
            <td><?= html_escape($proposal->lokasi); ?></td>
        </tr>
        <tr>
            <th>Status Pengajuan</th>
            <td>
                <strong><?= html_escape($proposal->status); ?></strong>
            </td>
        </tr>
        <tr>
            <th>Berkas File Proposal</th>
            <td><?= html_escape($proposal->proposal_file ? $proposal->proposal_file : 'Tidak ada file'); ?></td>
        </tr>
    </table>

    <div class="section-title">PROJEK BRIEF / DESKRIPSI KEGIATAN</div>
    <div class="box-text">
        <?= html_escape($proposal->projek_brief); ?>
    </div>

    <?php if($proposal->catatan): ?>
        <div class="section-title">CATATAN PENGAJUAN</div>
        <div class="box-text">
            <?= html_escape($proposal->catatan); ?>
        </div>
    <?php endif; ?>

    <?php if($proposal->catatan_revisi): ?>
        <div class="section-title">CATATAN REVISI / ADMIN</div>
        <div class="box-text" style="background-color: #FEF2F2; border-color: #FCA5A5; color: #991B1B;">
            <?= html_escape($proposal->catatan_revisi); ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($history)): ?>
        <div class="section-title">RIWAYAT PERUBAHAN STATUS</div>
        <table class="data-table">
            <tr style="background-color: #F3F4F6;">
                <th style="width: 25%; background-color: #374151;">Waktu</th>
                <th style="width: 20%; background-color: #374151;">Status</th>
                <th style="width: 25%; background-color: #374151;">Oleh</th>
                <th style="width: 30%; background-color: #374151;">Catatan</th>
            </tr>
            <?php foreach($history as $h): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($h->created_at)); ?></td>
                    <td><strong><?= html_escape($h->status); ?></strong></td>
                    <td><?= html_escape($h->changed_by); ?></td>
                    <td><?= html_escape($h->catatan ? $h->catatan : '-'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="footer-note">
        Dokumen ini merupakan bukti pengajuan proposal resmi Program Representative FICT - Horizon University Indonesia.
    </div>

</body>
</html>

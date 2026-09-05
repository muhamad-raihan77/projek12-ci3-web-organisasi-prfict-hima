<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran - <?= html_escape($applicant->registration_code); ?></title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
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
            font-size: 18px;
            font-weight: bold;
            color: #7A1F2B;
            text-transform: uppercase;
        }
        .sub-logo {
            font-size: 11px;
            color: #6B7280;
        }
        .title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #7A1F2B;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .code-box {
            background-color: #FAF8F8;
            border: 1px dashed #7A1F2B;
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
        }
        .code-box .label {
            font-size: 10px;
            color: #6B7280;
        }
        .code-box .code {
            font-size: 16px;
            font-weight: bold;
            color: #7A1F2B;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th, .data-table td {
            padding: 8px 10px;
            border: 1px solid #E5E7EB;
            text-align: left;
        }
        .data-table th {
            background-color: #7A1F2B;
            color: #FFFFFF;
            font-weight: bold;
            width: 30%;
        }
        .footer-note {
            margin-top: 30px;
            font-size: 10px;
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
                <td style="width: 60px;">
                    <?php 
                        $logo_file = FCPATH . 'assets/img/logo.png';
                        $logo_src = file_exists($logo_file) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logo_file)) : '';
                    ?>
                    <?php if($logo_src): ?>
                        <img src="<?= $logo_src; ?>" style="width: 50px; height: 50px; border-radius: 50%;" alt="PR FICT Logo">
                    <?php endif; ?>
                </td>
                <td>
                    <div class="logo-text">PROGRAM REPRESENTATIVE FICT</div>
                    <div class="sub-logo">Horizon University Indonesia</div>
                </td>
                <td style="text-align: right;">
                    <div style="font-size: 10px; color: #6B7280;">TANGGAL DAFTAR</div>
                    <div style="font-weight: bold;"><?= date('d F Y', strtotime($applicant->created_at)); ?></div>
                </td>
            </tr>
        </table>
    </div>

    <div class="title">BUKTI PENDAFTARAN ANGGOTA</div>

    <div class="code-box">
        <div class="label">KODE PENDAFTARAN</div>
        <div class="code"><?= html_escape($applicant->registration_code); ?></div>
    </div>

    <table class="data-table">
        <tr>
            <th>Nama Lengkap</th>
            <td><?= html_escape($applicant->full_name); ?></td>
        </tr>
        <tr>
            <th>NIM</th>
            <td><?= html_escape($applicant->nim); ?></td>
        </tr>
        <tr>
            <th>Program Studi</th>
            <td><?= html_escape($applicant->study_program); ?></td>
        </tr>
        <tr>
            <th>Semester</th>
            <td>Semester <?= html_escape($applicant->semester); ?></td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td><?= html_escape($applicant->gender); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= html_escape($applicant->email); ?></td>
        </tr>
        <tr>
            <th>WhatsApp</th>
            <td><?= html_escape($applicant->whatsapp); ?></td>
        </tr>
        <tr>
            <th>Pilihan Divisi</th>
            <td><strong><?= html_escape($applicant->division_name); ?></strong></td>
        </tr>
        <tr>
            <th>Alasan Bergabung</th>
            <td><?= nl2br(html_escape($applicant->reason)); ?></td>
        </tr>
        <tr>
            <th>Pengalaman Organisasi</th>
            <td><?= !empty($applicant->organization_experience) ? nl2br(html_escape($applicant->organization_experience)) : '-'; ?></td>
        </tr>
        <tr>
            <th>Keahlian / Skill</th>
            <td><?= !empty($applicant->skills) ? html_escape($applicant->skills) : '-'; ?></td>
        </tr>
        <tr>
            <th>Status Pendaftaran</th>
            <td><strong><?= strtoupper(html_escape($applicant->status)); ?></strong></td>
        </tr>
    </table>

    <div class="footer-note">
        Dokumen ini merupakan bukti pendaftaran sah Open Recruitment Program Representative FICT 2026.<br>
        Dicetak secara otomatis oleh sistem pada <?= date('d/m/Y H:i:s'); ?>.
    </div>

</body>
</html>

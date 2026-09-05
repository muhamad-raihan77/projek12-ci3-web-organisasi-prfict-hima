# Sistem Informasi & Rekrutmen PR FICT 🚀
> **Program Representative Faculty of Information and Communication Technology (FICT)**  
> **Horizon University Indonesia**

Aplikasi berbasis web terpadu untuk organisasi **PR FICT (Kabinet Adhiyakhsa)** yang mencakup portal informasi organisasi, sistem open recruitment mahasiswa, pengajuan proposal kegiatan, manajemen program kerja & dokumentasi, serta panel administrasi terpusat.

---

## 📌 Fitur Utama

### 1. 🎓 Portal Mahasiswa & Rekrutmen
- **Landing Page Interaktif**: Menampilkan profil organisasi, visi & misi, struktur kepengurusan Kabinet Adhiyakhsa, dan daftar divisi.
- **Autentikasi Mahasiswa**: Fitur daftar akun baru dan login khusus mahasiswa.
- **Formulir Pendaftaran Seleksi**: Pengisian data lengkap pendaftar, pilihan divisi minat, upload Curriculum Vitae (CV) dan foto resmi.
- **Tracking Status Real-time**: Pelacakan status seleksi secara berkala (*Menunggu, Seleksi Administrasi, Interview, Lolos, Tidak Lolos*).
- **Cetak Bukti Registrasi**: Fitur cetak / download kartu bukti pendaftaran seleksi.
- **Profil & Biodata**: Kelola data diri mahasiswa beserta riwayat pengajuan.

### 2. 📋 Pengajuan Proposal & Program Kerja
- **Pengajuan Proposal Kegiatan**: Mahasiswa/anggota dapat mengajukan rencana kegiatan baru lengkap dengan file proposal PDF, tanggal, lokasi, dan deskripsi kegiatan.
- **Pelacakan Status Proposal**: Riwayat tahapan pengajuan (*Submit, Review, Revisi, Approve*) beserta catatan dari pengurus/admin.
- **Katalog Program Kerja**: Menampilkan status jalannya program kerja (*Belum Dimulai, Berjalan, Selesai*) beserta galeri dokumentasi kegiatan.

### 3. 🛡️ Panel Admin (Backoffice)
- **Dashboard Analytics**: Statistik total pelamar, status seleksi, dan ringkasan divisi.
- **Manajemen Seleksi Pelamar**: Verifikasi berkas CV & foto, filter per divisi, dan perubahan status seleksi.
- **Manajemen Divisi**: Tambah, edit, dan hapus divisi organisasi beserta deskripsi dan ikon.
- **Manajemen Pengurus Organisasi**: Pengaturan foto, jabatan, hierarki, dan profil sosial media pengurus.
- **Manajemen Program Kerja**: Pengelolaan proker, PIC, target, dan unggah foto dokumentasi kegiatan.
- **Review & Approval Proposal**: Tinjau proposal masuk, beri catatan/revisi, dan ubah status persetujuan.

---

## 🛠️ Tech Stack

- **Framework**: [CodeIgniter 3](https://codeigniter.com/) (PHP MVC Framework)
- **Bahasa**: PHP (>= 7.4 / 8.x didukung)
- **Database**: MySQL / MariaDB
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap, FontAwesome Icons
- **Libraries**:
  - `dompdf/dompdf`: Library untuk pembuatan dokumen dan cetak bukti PDF
- **Web Server**: Apache (Laragon / XAMPP)

---

## 📁 Struktur Direktori

```text
projek12/
├── application/
│   ├── config/              # Konfigurasi aplikasi, database, routes, autoload
│   ├── controllers/         # Controller frontend & admin
│   ├── models/              # Model query database
│   └── views/               # Tampilan UI (frontend & admin panel)
├── assets/
│   ├── css/                 # Custom stylesheet
│   ├── js/                  # JavaScript frontend
│   └── img/                 # Aset logo dan gambar statis
├── database/
│   ├── prfict_db.sql        # Database master lengkap siap import
│   └── migrations/          # File migrasi referensi tambahan
├── system/                  # Core library CodeIgniter 3
├── uploads/                 # Direktori media upload (CV, foto, proposal, dokumentasi)
├── .editorconfig            # Standar format koding
├── .gitignore               # Konfigurasi file yang diabaikan git
├── .htaccess                # URL rewrite Apache (clean URL)
├── composer.json            # Daftar dependensi library PHP
└── index.php                # Front controller utama
```

---

## 🚀 Panduan Instalasi Lokal

### 1. Prasyarat Lingkungan
- Web server lokal: **Laragon** (direkomendasikan) atau **XAMPP**
- PHP versi **7.4** atau **8.x**
- MySQL / MariaDB
- Git & Composer

### 2. Konfigurasi Proyek

1. **Clone repository ini ke folder server lokal Anda:**
   ```bash
   # Masuk ke direktori web server (contoh Laragon)
   cd C:\laragon\www
   
   # Clone repo
   git clone https://github.com/USERNAME/REPO-NAME.git projek12
   cd projek12
   ```

2. **Import Database:**
   - Buka **phpMyAdmin** atau GUI database MySQL Anda (`HeidiSQL` / `DBeaver`).
   - Buat database baru bernama `prfict_db` (atau otomatis dibuat saat import).
   - Import file:
     ```text
     database/prfict_db.sql
     ```

3. **Konfigurasi Database:**
   - Cek file [application/config/database.php](file:///c:/laragon/www/projek12/application/config/database.php) (atau salin dari `database.php.example`).
   - Sesuaikan username dan password MySQL Anda:
     ```php
     $db['default'] = array(
         'hostname' => 'localhost',
         'username' => 'root',
         'password' => '',
         'database' => 'prfict_db',
         ...
     );
     ```

4. **Install Dependensi Composer:**
   ```bash
   composer install
   ```

5. **Akses Aplikasi Melalui Browser:**
   - Jika menggunakan Laragon: `http://projek12.test` atau `http://localhost/projek12`
   - Halaman Utama: `http://localhost/projek12`
   - Panel Login Admin: `http://localhost/projek12/admin/auth`

---


---

## 📄 Lisensi & Hak Cipta
Dikembangkan untuk kebutuhan internal organisasi **Program Representative Faculty of Information and Communication Technology (PR FICT)** Horizon University Indonesia.

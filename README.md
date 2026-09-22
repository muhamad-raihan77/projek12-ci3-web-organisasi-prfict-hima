Tech Stack

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

## 📄 Lisensi & Hak Cipta
Dikembangkan untuk kebutuhan internal organisasi **Program Representative Faculty of Information and Communication Technology (PR FICT)** Horizon University Indonesia.

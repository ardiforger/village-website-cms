# Website Desa Makmur

Website resmi pemerintah desa (fiktif) — media informasi, transparansi, dan komunikasi antara pemerintah desa dengan masyarakat. Dibangun dengan PHP native (procedural + PDO) sebagai latihan mengelola aplikasi web tanpa framework.

## Preview

**Homepage**

![Homepage](/homepage.jpg)

**Profil Desa**

![Profil Desa](/profil-desa.png)

**Admin Dashboard**

![Admin Dashboard](/admin-dashboard.png)

## Tentang Proyek

Proyek ini merupakan simulasi sistem informasi desa lengkap dengan sisi publik (frontend) dan panel manajemen konten (backend admin). Dibangun sebagai latihan pribadi dalam bekerja dengan PHP native, PDO, dan perancangan skema database relasional — di luar jalur utama pembelajaran front-end.

## Fitur

### Sisi Publik (Frontend)

- Homepage dengan carousel gambar dinamis dan statistik desa
- Halaman profil desa (sejarah, visi-misi, struktur organisasi, wilayah & demografi)
- Berita dengan kategori, jumlah views, dan halaman detail
- Galeri foto per kategori
- Halaman layanan publik & kontak
- Layout responsif menggunakan Bootstrap 5

### Panel Admin (Backend)

- **Role-Based Access Control** dengan tiga level akses:
  - **Admin** — akses penuh ke seluruh fitur dan manajemen user
  - **Editor** — kelola berita, galeri, dan profil desa
  - **Author** — hanya dapat mengelola berita
- CRUD berita, galeri, dan carousel homepage
- Manajemen profil desa & pengaturan umum website
- Manajemen akun pengguna admin
- Dashboard ringkasan (total berita, status publish/draft, jumlah foto galeri)

## Tech Stack

- **Backend:** PHP native (procedural), PDO untuk akses database
- **Database:** MySQL/MariaDB
- **Frontend:** Bootstrap 5, Font Awesome
- **Keamanan:** Password di-hash dengan bcrypt

## Struktur Proyek

```
website-desa-makmur/
├── admin/            # Panel manajemen konten (CMS)
├── assets/           # Gambar, CSS, JS statis
├── includes/         # Config, header, footer, koneksi database
├── pages/            # Halaman publik (profil, layanan, berita, dsb.)
├── uploads/          # Hasil upload gambar (carousel, artikel, galeri)
├── index.php         # Halaman utama (homepage)
├── website_desa.sql  # Skema database + seeder data
└── README.md
```

## Skema Database

| Tabel | Fungsi |
|---|---|
| `users` | Akun admin dengan role (`admin`, `editor`, `author`) |
| `berita` | Artikel berita, relasi ke penulis via `penulis_id` |
| `carousel` | Slide gambar homepage |
| `galeri` | Foto galeri per kategori |
| `profil_desa` | Data profil (sejarah, visi-misi, struktur organisasi) |
| `statistik_desa` | Statistik ringkas (jumlah penduduk, luas wilayah, dsb.) |
| `pengaturan` | Pengaturan umum situs (nama, keywords, social media) |
| `kontak` | Pesan masuk dari form kontak |

## Instalasi

1. **Kebutuhan sistem**
   - PHP 7.4+
   - MySQL 5.7+
   - Web server lokal (disarankan Laragon/XAMPP/WAMP)

2. **Setup database**
   - Buat database baru bernama `website_desa`
   - Import `website_desa.sql` ke database tersebut

3. **Akses aplikasi**
   - Frontend: `http://localhost/website_desa/`
   - Panel admin: `http://localhost/website_desa/admin/`

### Akun Default (Testing)

| Username | Password | Role |
|---|---|---|
| `admin` | `password` | Admin |
| `editor` | `password` | Editor |
| `author` | `password` | Author |

> Ganti password default ini setelah instalasi, kredensial di atas hanya untuk keperluan pengujian lokal.

## Catatan

Proyek ini merupakan latihan pribadi di luar jalur utama (native PHP, bukan framework seperti Laravel), sehingga disimpan sebagai repository privat dan tidak dijadikan bagian dari portofolio publik.

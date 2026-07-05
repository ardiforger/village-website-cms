# 🏛️ Website Desa Makmur

**Website Resmi Pemerintah Desa Makmur** — Media informasi, transparansi, dan komunikasi modern antara Pemerintah Desa dengan masyarakat. Dibangun dengan fokus pada kecepatan dan kemudahan akses.

## ✨ Fitur Utama (Highlight)

### 🖥️ Frontend (Untuk Masyarakat)

Fitur yang berorientasi pada pengguna, memberikan informasi yang akurat dan mudah diakses:

| Status | Fitur | Deskripsi |
| :---: | :--- | :--- |
| ✅ | **Homepage Dinamis** | Tampilan modern dengan *carousel* gambar bergerak dan statistik desa *real-time*. |
| ✅ | **Profil Desa Lengkap** | Halaman khusus untuk Sejarah, Visi Misi, dan Struktur Organisasi Desa. |
| ✅ | **Berita Profesional** | Layout berita responsif yang terinspirasi dari media besar (e.g., CNN Indonesia). |
| ✅ | **Galeri Foto** | Album foto yang terorganisir per kategori. |
| ✅ | **Layanan Publik & Kontak** | Informasi layanan desa, Form Kontak, dan integrasi langsung ke WhatsApp. |
| ✅ | **Responsiveness** | Desain sepenuhnya *mobile-friendly* (Bootstrap 5 Ready). |

### ⚙️ Backend Admin (Untuk Pemerintah Desa)

Sistem manajemen konten (CMS) yang kuat dan terstruktur untuk pengelola desa:

-   **Sistem User Multi-Level (RBAC):**
    -   **Admin** (Kepala Desa) - Akses penuh ke semua fitur dan pengaturan.
    -   **Editor** (Sekretaris) - Kelola Berita, Galeri, dan Profil Desa.
    -   **Author** (Bendahara) - Hanya diperbolehkan untuk mengelola Berita.
-   **Manajemen Konten:** CRUD Berita dengan *Rich Text Editor* (WYSIWYG) dan *thumbnail*.
-   **Kustomisasi Dinamis:** Kelola *carousel* homepage, edit profil desa, dan pengaturan website umum.
-   **Manajemen Pengguna:** Kontrol penuh terhadap akun administrator.

## 🛠️ Panduan Instalasi Cepat

Proyek ini memerlukan lingkungan *server* lokal untuk dijalankan:

### 1. Kebutuhan Sistem (Requirements)

* PHP 7.4 atau lebih tinggi
* MySQL 5.7 atau lebih tinggi
* Web server (Apache/Nginx)
* Disarankan menggunakan: **Laragon / XAMPP / WAMP**

### 2. Setup Database

1.  Buka phpMyAdmin atau *database client* Anda.
2.  Buat database baru dengan nama: `website_desa`.
3.  Import file `website_desa.sql` yang sudah disediakan ke database yang baru dibuat.
4.  Database Anda kini sudah terisi:
    -   Tabel struktur lengkap dan *seeder* data.
    -   User *default* untuk pengujian.
    -   5 contoh artikel berita.
    -   Data profil desa awal.

### 3. Akses Panel Admin

Panel Admin dapat diakses melalui URL:

`http://localhost/website_desa/admin/`

### 🔒 Akun Login Default (Untuk Testing)

Gunakan akun berikut untuk menguji berbagai level akses di sistem:

| Username | Password | Role | Keterangan |
| :--- | :--- | :--- | :--- |
| **admin** | `password` | Admin | Kepala Desa (Akses Penuh) |
| **editor** | `password` | Editor | Sekretaris Desa (Kelola Berita & Galeri) |
| **author** | `password` | Author | Bendahara Desa (Hanya Kelola Berita) |

***Penting!*** *Segera ganti password default ini setelah instalasi berhasil untuk alasan keamanan.*

---

## 👨‍💻 Creative & Development

**Dibuat dan dikembangkan oleh:**

### **Ardi Wirya**

Terima kasih telah menggunakan proyek ini!

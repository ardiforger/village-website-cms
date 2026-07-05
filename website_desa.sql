-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 12, 2025 at 10:32 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `website_desa`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `penulis_id` int DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `status` enum('draft','publish') DEFAULT 'draft',
  `views` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `judul`, `slug`, `konten`, `thumbnail`, `penulis_id`, `kategori`, `status`, `views`, `created_at`, `updated_at`) VALUES
(1, 'Pembangunan Jalan Desa Makmur Selesai Lebih Cepat', 'pembangunan-jalan-desa-makmur-selesai-lebih-cepat', '<h2>Proyek Infrastruktur Berjalan Lancar</h2>\r\n<p>Pembangunan jalan sepanjang 2 kilometer di Desa Makmur telah selesai lebih cepat dari jadwal yang direncanakan. Proyek yang dimulai tiga bulan lalu ini berhasil diselesaikan dalam waktu 2,5 bulan.</p>\r\n<p>Kepala Desa, Budi Santoso, menyatakan kebanggaannya atas pencapaian ini. \"Ini adalah bukti komitmen kami untuk meningkatkan konektivitas dan perekonomian desa,\" ujarnya.</p>\r\n<h3>Dampak Positif bagi Warga</h3>\r\n<p>Warga setempat sangat antusias dengan pembukaan jalan baru ini. \"Sekarang lebih mudah menjual hasil pertanian ke pasar,\" kata Siti, salah satu petani di desa.</p>', 'berita_1760264368.jpg', 1, 'Pembangunan', 'publish', 0, '2024-01-15 03:00:00', '2025-10-12 10:19:28'),
(2, 'Festival Budaya Desa Makmur Sukses Digelar', 'festival-budaya-desa-makmur-sukses-digelar', '<h2>Merayakan Kearifan Lokal</h2><p>Festival budaya tahunan Desa Makmur kembali digelar dengan sukses. Acara yang berlangsung selama tiga hari ini menampilkan berbagai kesenian tradisional dan kuliner khas desa.</p><p>Lebih dari 1.000 pengunjung hadir dari berbagai daerah untuk menyaksikan langsung kekayaan budaya yang dimiliki Desa Makmur.</p><h3>Ragam Pertunjukan</h3><ul><li>Tari tradisional \"Lenggang Makmur\"</li><li>Pameran kerajinan tangan warga</li><li>Lomba masak makanan tradisional</li><li>Pertunjukan wayang kulit</li></ul>', 'festival_budaya.jpg', 2, 'Budaya', 'publish', 0, '2024-01-12 07:30:00', '2025-10-12 09:50:42'),
(3, 'Program Pelatihan Kewirausahaan untuk Pemuda Desa', 'program-pelatihan-kewirausahaan-untuk-pemuda-desa', '<h2>Meningkatkan Kompetensi Generasi Muda</h2><p>Pemerintah Desa Makmur bekerjasama dengan Dinas Koperasi mengadakan program pelatihan kewirausahaan bagi pemuda desa. Program ini diikuti oleh 50 peserta dari berbagai dusun.</p><p>Pelatihan berfokus pada pengembangan usaha mikro, digital marketing, dan manajemen keuangan sederhana.</p><h3>Testimoni Peserta</h3><p>\"Saya belajar banyak tentang cara memulai usaha online. Sekarang saya bisa menjual kerajinan tangan saya melalui media sosial,\" ujar Rina, salah satu peserta.</p>', 'pelatihan_wirausaha.jpg', 1, 'Ekonomi', 'publish', 2, '2024-01-10 02:15:00', '2025-10-12 09:52:40'),
(4, 'Posyandu Desa Catat Peningkatan Kesehatan Ibu dan Anak', 'posyandu-desa-catat-peningkatan-kesehatan-ibu-dan-anak', '<h2>Kemajuan di Bidang Kesehatan</h2><p>Posyandu Melati Desa Makmur mencatat kemajuan signifikan dalam hal kesehatan ibu dan anak. Angka stunting turun dari 15% menjadi 8% dalam satu tahun terakhir.</p><p>Pencapaian ini tidak lepas dari program intensif yang dilakukan oleh kader posyandu dan dukungan penuh dari puskesmas setempat.</p><h3>Program Unggulan</h3><ul><li>Pemeriksaan kesehatan rutin bulanan</li><li>Kelas ibu hamil</li><li>Pemberian makanan tambahan</li><li>Edukasi gizi seimbang</li></ul>', 'posyandu_desa.jpg', 3, 'Kesehatan', 'publish', 2, '2024-01-08 09:45:00', '2025-10-12 09:52:41'),
(5, 'Desa Makmur Raih Penghargaan Desa Terbersih Se-Kecamatan', 'desa-makmur-raih-penghargaan-desa-terbersih-se-kecamatan', '<h2>Prestasi Membanggakan</h2><p>Desa Makmur meraih penghargaan sebagai Desa Terbersih se-Kecamatan Sajahiera dalam lomba kebersihan tingkat kecamatan. Penghargaan diterima langsung oleh Kepala Desa di Balai Kecamatan.</p><p>Penilaian dilakukan berdasarkan kebersihan lingkungan, pengelolaan sampah, dan partisipasi masyarakat dalam menjaga kebersihan.</p><h3>Strategi Kebersihan</h3><p>\"Kami menerapkan sistem bank sampah dan jadwal kerja bakti rutin. Semua warga berpartisipasi aktif,\" jelas Sekretaris Desa, Siti Aminah.</p>', 'penghargaan_desa.jpg', 2, 'Lingkungan', 'publish', 0, '2024-01-05 04:20:00', '2025-10-12 09:50:42');

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `id` int NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `gambar` varchar(255) NOT NULL,
  `urutan` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`id`, `judul`, `deskripsi`, `gambar`, `urutan`, `is_active`, `created_at`) VALUES
(1, 'Desa', 'Tampak Desa', 'carousel_1760262831.jpg', 1, 1, '2025-10-12 09:53:51'),
(2, 'Gambar Desa', 'sawah', 'carousel_1760262958.jpg', 2, 1, '2025-10-12 09:55:58');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text,
  `gambar` varchar(255) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id`, `judul`, `deskripsi`, `gambar`, `kategori`, `created_at`) VALUES
(1, 'Tes foto', 'bareng', 'galeri_1760263043.jpg', 'Budaya', '2025-10-12 09:57:23');

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `subjek` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `status` enum('baru','dibaca','dibalas') DEFAULT 'baru',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int NOT NULL,
  `nama_setting` varchar(100) NOT NULL,
  `nilai_setting` text,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `nama_setting`, `nilai_setting`, `keterangan`) VALUES
(1, 'website_nama', 'Desa Makmur', 'Nama website'),
(2, 'website_deskripsi', 'Website Resmi Pemerintah Desa Makmur', 'Deskripsi website'),
(3, 'website_keywords', 'desa, makmur, pemerintah', 'Keywords website'),
(4, 'social_facebook', '#', 'Link Facebook'),
(5, 'social_instagram', '#', 'Link Instagram'),
(6, 'social_youtube', '#', 'Link YouTube'),
(7, 'whatsapp_number', '62123456789', 'Nomor WhatsApp');

-- --------------------------------------------------------

--
-- Table structure for table `profil_desa`
--

CREATE TABLE `profil_desa` (
  `id` int NOT NULL,
  `nama_desa` varchar(100) NOT NULL,
  `alamat` text,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sejarah` text,
  `visi_misi` text,
  `struktur_organisasi` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `profil_desa`
--

INSERT INTO `profil_desa` (`id`, `nama_desa`, `alamat`, `telepon`, `email`, `sejarah`, `visi_misi`, `struktur_organisasi`, `created_at`, `updated_at`) VALUES
(1, 'Desa Makmur', 'Kecamatan Sajahiera - Kabupaten Makmur Jaya', '(021) 1234-5678', 'desamakmur@email.com', 'Sejarah Desa Makmur...', 'Visi Misi Desa Makmur...', NULL, '2025-10-12 07:09:40', '2025-10-12 07:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `statistik_desa`
--

CREATE TABLE `statistik_desa` (
  `id` int NOT NULL,
  `nama_statistik` varchar(100) NOT NULL,
  `nilai_statistik` varchar(50) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `urutan` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `statistik_desa`
--

INSERT INTO `statistik_desa` (`id`, `nama_statistik`, `nilai_statistik`, `icon`, `urutan`, `created_at`) VALUES
(1, 'Jiwa Penduduk', '2,500+', 'fas fa-users', 1, '2025-10-12 07:56:56'),
(2, 'Luas Wilayah', '500 Ha', 'fas fa-map', 2, '2025-10-12 07:56:56'),
(3, 'Dusun', '4', 'fas fa-home', 3, '2025-10-12 07:56:56'),
(4, 'Kepala Keluarga', '650', 'fas fa-house-user', 4, '2025-10-12 07:56:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('admin','editor','author') DEFAULT 'author',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `nama_lengkap`, `role`, `created_at`, `is_active`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@desamakmur.com', 'Administrator', 'admin', '2025-10-12 07:09:40', 1),
(2, 'editor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'editor@desamakmur.com', 'Sekretaris Desa', 'editor', '2025-10-12 07:09:40', 1),
(3, 'author', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'author@desamakmur.com', 'Bendahara Desa', 'author', '2025-10-12 07:09:40', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `penulis_id` (`penulis_id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_setting` (`nama_setting`);

--
-- Indexes for table `profil_desa`
--
ALTER TABLE `profil_desa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statistik_desa`
--
ALTER TABLE `statistik_desa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `profil_desa`
--
ALTER TABLE `profil_desa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `statistik_desa`
--
ALTER TABLE `statistik_desa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `berita_ibfk_1` FOREIGN KEY (`penulis_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

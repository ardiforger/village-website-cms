<?php
// pages/includes/header-pages.php
$profil_query = $pdo->query("SELECT * FROM profil_desa LIMIT 1");
$profil = $profil_query->fetch(PDO::FETCH_ASSOC);

// Determine active page
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Makmur - Website Resmi</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation dengan Logo di Sisi Kiri -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <!-- Logo dan Nama Desa -->
            <a class="navbar-brand d-flex align-items-center" href="../index.php">
                <img src="../assets/images/logo/logo-desa.png" alt="Logo Desa" height="40" class="me-2">
                <div>
                    <strong class="mb-0">Desa Makmur</strong>
                    <small class="d-none d-md-block">Kecamatan Sajahiera - Kabupaten Makmur Jaya</small>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>" href="../index.php">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= ($current_page == 'profil.php') ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown">
                            Profil Desa
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profil.php?section=sejarah">Sejarah</a></li>
                            <li><a class="dropdown-item" href="profil.php?section=visi-misi">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="profil.php?section=struktur">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="profil.php?section=pemerintahan">Pemerintahan</a></li>
                            <li><a class="dropdown-item" href="profil.php?section=wilayah">Wilayah & Demografi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'layanan.php') ? 'active' : '' ?>" href="layanan.php">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (in_array($current_page, ['berita.php', 'berita-detail.php'])) ? 'active' : '' ?>" href="berita.php">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'galeri.php') ? 'active' : '' ?>" href="galeri.php">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'kontak.php') ? 'active' : '' ?>" href="kontak.php">Kontak</a>
                    </li>
                </ul>
                
                <!-- Tombol Admin di Sisi Kanan -->
                <div class="navbar-nav">
                    <a href="../admin/login.php" class="btn btn-light btn-sm">
                        <i class="fas fa-sign-in-alt me-1"></i> Admin
                    </a>
                </div>
            </div>
        </div>
    </nav>
<?php
// admin/dashboard.php
include '../includes/config.php';
include '../includes/auth.php';
checkAuth();

// Ambil statistik
$total_berita = $pdo->query("SELECT COUNT(*) FROM berita")->fetchColumn();
$total_galeri = $pdo->query("SELECT COUNT(*) FROM galeri")->fetchColumn();
$berita_publish = $pdo->query("SELECT COUNT(*) FROM berita WHERE status = 'publish'")->fetchColumn();
$berita_draft = $pdo->query("SELECT COUNT(*) FROM berita WHERE status = 'draft'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Desa Makmur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="../assets/css/admin.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">
                <i class="fas fa-home me-2"></i>Admin Panel - Desa Makmur
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                    <?php if(isAdmin() || isEditor()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="artikel.php">Berita</a>
                    </li>
                    <?php endif; ?>
                    <?php if(isAdmin() || isEditor()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="galeri.php">Galeri</a>
                    </li>
                    <?php endif; ?>
                    <?php if(isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="carousel.php">Carousel</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">Profil Desa</a>
                    </li>
                    <?php if(isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="pengaturan.php">Pengaturan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Users</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <div class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i><?= $_SESSION['nama_lengkap'] ?> (<?= $_SESSION['role'] ?>)
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../index.php" target="_blank"><i class="fas fa-globe me-2"></i>Lihat Website</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </nav>

    <!-- ... kode sidebar dan content tetap sama ... -->

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <!-- Di file admin/dashboard.php, bagian sidebar -->
<div class="position-sticky pt-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="dashboard.php">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </li>
        <?php if(isAdmin() || isEditor() || isAuthor()): ?>
        <li class="nav-item">
            <a class="nav-link" href="artikel.php">
                <i class="fas fa-newspaper me-2"></i>Manajemen Berita
            </a>
        </li>
        <?php endif; ?>
        <?php if(isAdmin() || isEditor()): ?>
        <li class="nav-item">
            <a class="nav-link" href="galeri.php">
                <i class="fas fa-images me-2"></i>Galeri Foto
            </a>
        </li>
        <?php endif; ?>
        <?php if(isAdmin()): ?>
        <li class="nav-item">
            <a class="nav-link" href="carousel.php">
                <i class="fas fa-sliders-h me-2"></i>Carousel
            </a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link" href="profil.php">
                <i class="fas fa-info-circle me-2"></i>Profil Desa
            </a>
        </li>
        <?php if(isAdmin()): ?>
        <li class="nav-item">
            <a class="nav-link" href="pengaturan.php">
                <i class="fas fa-cog me-2"></i>Pengaturan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="users.php">
                <i class="fas fa-users me-2"></i>Manajemen User
            </a>
        </li>
        <?php endif; ?>
    </ul>
</div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <span class="badge bg-primary"><?= ucfirst($_SESSION['role']) ?></span>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Berita</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_berita ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Berita Publis</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $berita_publish ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Berita Draft</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $berita_draft ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-edit fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Foto Galeri</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_galeri ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-images fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php if(isAdmin() || isEditor()): ?>
                                    <div class="col-md-3 mb-3">
                                        <a href="artikel.php?action=tambah" class="btn btn-primary w-100">
                                            <i class="fas fa-plus me-2"></i>Tambah Berita
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                    <?php if(isAdmin() || isEditor()): ?>
                                    <div class="col-md-3 mb-3">
                                        <a href="galeri.php?action=tambah" class="btn btn-success w-100">
                                            <i class="fas fa-image me-2"></i>Tambah Foto
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                    <?php if(isAdmin()): ?>
                                    <div class="col-md-3 mb-3">
                                        <a href="carousel.php?action=tambah" class="btn btn-info w-100">
                                            <i class="fas fa-sliders-h me-2"></i>Kelola Carousel
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                    <div class="col-md-3 mb-3">
                                        <a href="profil.php" class="btn btn-warning w-100">
                                            <i class="fas fa-edit me-2"></i>Edit Profil
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/admin.js"></script>
</body>
</html>
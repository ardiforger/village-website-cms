<?php
// admin/pengaturan.php
include '../includes/config.php';
include '../includes/auth.php';
checkAuth();
checkRole(['admin']); // Hanya admin yang bisa akses

// Ambil semua pengaturan
$stmt = $pdo->query("SELECT * FROM pengaturan");
$pengaturan_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Konversi ke array asosiatif
$pengaturan = [];
foreach ($pengaturan_list as $setting) {
    $pengaturan[$setting['nama_setting']] = $setting;
}

// Proses update pengaturan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'setting_') === 0) {
            $nama_setting = str_replace('setting_', '', $key);
            $nilai_setting = clean_input($value);
            
            $stmt = $pdo->prepare("UPDATE pengaturan SET nilai_setting = ? WHERE nama_setting = ?");
            $stmt->execute([$nilai_setting, $nama_setting]);
        }
    }
    
    $success = "Pengaturan berhasil diperbarui!";
    
    // Refresh data
    $stmt = $pdo->query("SELECT * FROM pengaturan");
    $pengaturan_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pengaturan = [];
    foreach ($pengaturan_list as $setting) {
        $pengaturan[$setting['nama_setting']] = $setting;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Website - Admin Desa Makmur</title>
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
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="artikel.php">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="galeri.php">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="carousel.php">Carousel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">Profil Desa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="pengaturan.php">Pengaturan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Manajemen User</a>
                    </li>
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

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="artikel.php">
                                <i class="fas fa-newspaper me-2"></i>Manajemen Berita
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="galeri.php">
                                <i class="fas fa-images me-2"></i>Galeri Foto
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="carousel.php">
                                <i class="fas fa-sliders-h me-2"></i>Carousel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profil.php">
                                <i class="fas fa-info-circle me-2"></i>Profil Desa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="pengaturan.php">
                                <i class="fas fa-cog me-2"></i>Pengaturan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users.php">
                                <i class="fas fa-users me-2"></i>Manajemen User
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php if(isset($success)): ?>
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <?= $success ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Pengaturan Website</h1>
                    <a href="../index.php" target="_blank" class="btn btn-info">
                        <i class="fas fa-eye me-1"></i>Lihat Website
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <h5 class="card-title mb-4"><i class="fas fa-globe me-2"></i>Informasi Website</h5>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="setting_website_nama" class="form-label">Nama Website</label>
                                    <input type="text" class="form-control" id="setting_website_nama" name="setting_website_nama" value="<?= $pengaturan['website_nama']['nilai_setting'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="setting_whatsapp_number" class="form-label">Nomor WhatsApp</label>
                                    <input type="text" class="form-control" id="setting_whatsapp_number" name="setting_whatsapp_number" value="<?= $pengaturan['whatsapp_number']['nilai_setting'] ?>" placeholder="62xxxxxxxxxx">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="setting_website_deskripsi" class="form-label">Deskripsi Website</label>
                                <textarea class="form-control" id="setting_website_deskripsi" name="setting_website_deskripsi" rows="3"><?= $pengaturan['website_deskripsi']['nilai_setting'] ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="setting_website_keywords" class="form-label">Keywords SEO</label>
                                <input type="text" class="form-control" id="setting_website_keywords" name="setting_website_keywords" value="<?= $pengaturan['website_keywords']['nilai_setting'] ?>">
                                <div class="form-text">Pisahkan dengan koma (contoh: desa, makmur, pemerintah)</div>
                            </div>

                            <hr class="my-4">

                            <h5 class="card-title mb-4"><i class="fas fa-share-alt me-2"></i>Media Sosial</h5>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="setting_social_facebook" class="form-label">Facebook</label>
                                    <input type="url" class="form-control" id="setting_social_facebook" name="setting_social_facebook" value="<?= $pengaturan['social_facebook']['nilai_setting'] ?>" placeholder="https://facebook.com/...">
                                </div>
                                <div class="col-md-4">
                                    <label for="setting_social_instagram" class="form-label">Instagram</label>
                                    <input type="url" class="form-control" id="setting_social_instagram" name="setting_social_instagram" value="<?= $pengaturan['social_instagram']['nilai_setting'] ?>" placeholder="https://instagram.com/...">
                                </div>
                                <div class="col-md-4">
                                    <label for="setting_social_youtube" class="form-label">YouTube</label>
                                    <input type="url" class="form-control" id="setting_social_youtube" name="setting_social_youtube" value="<?= $pengaturan['social_youtube']['nilai_setting'] ?>" placeholder="https://youtube.com/...">
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Isi URL lengkap media sosial (contoh: https://facebook.com/namapage)
                            </div>

                            <hr class="my-4">

                            <h5 class="card-title mb-4"><i class="fas fa-database me-2"></i>Data Statistik</h5>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="statistik_penduduk" class="form-label">Jumlah Penduduk</label>
                                    <input type="text" class="form-control" id="statistik_penduduk" name="statistik_penduduk" value="2,500+">
                                </div>
                                <div class="col-md-3">
                                    <label for="statistik_luas" class="form-label">Luas Wilayah</label>
                                    <input type="text" class="form-control" id="statistik_luas" name="statistik_luas" value="500 Ha">
                                </div>
                                <div class="col-md-3">
                                    <label for="statistik_dusun" class="form-label">Jumlah Dusun</label>
                                    <input type="text" class="form-control" id="statistik_dusun" name="statistik_dusun" value="4">
                                </div>
                                <div class="col-md-3">
                                    <label for="statistik_kk" class="form-label">Kepala Keluarga</label>
                                    <input type="text" class="form-control" id="statistik_kk" name="statistik_kk" value="650">
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan Semua Pengaturan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Informasi</h6>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li>Perubahan pengaturan akan langsung diterapkan di website</li>
                            <li>Pastikan URL media sosial diisi dengan format yang benar</li>
                            <li>Nomor WhatsApp harus diawali dengan kode negara (62 untuk Indonesia)</li>
                            <li>Keywords penting untuk SEO website</li>
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
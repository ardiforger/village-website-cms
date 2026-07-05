<?php
// admin/profil.php
include '../includes/config.php';
include '../includes/auth.php';
// Di bagian atas file, setelah include auth.php
checkAuth();

// Tambahkan permission check berdasarkan halaman
$current_file = basename(__FILE__);
$permissions = [
    'artikel.php' => ['admin', 'editor', 'author'],
    'galeri.php' => ['admin', 'editor'],
    'carousel.php' => ['admin'],
    'profil.php' => ['admin', 'editor', 'author'],
    'users.php' => ['admin'],
    'pengaturan.php' => ['admin']
];

if (isset($permissions[$current_file])) {
    checkRole($permissions[$current_file]);
}

// Ambil data profil desa
$stmt = $pdo->query("SELECT * FROM profil_desa LIMIT 1");
$profil = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$profil) {
    // Insert default jika belum ada
    $pdo->query("INSERT INTO profil_desa (nama_desa, alamat, telepon, email) VALUES ('Desa Makmur', 'Kecamatan Sajahiera - Kabupaten Makmur Jaya', '(021) 1234-5678', 'desamakmur@email.com')");
    $stmt = $pdo->query("SELECT * FROM profil_desa LIMIT 1");
    $profil = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Proses update profil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_desa = clean_input($_POST['nama_desa']);
    $alamat = clean_input($_POST['alamat']);
    $telepon = clean_input($_POST['telepon']);
    $email = clean_input($_POST['email']);
    $sejarah = $_POST['sejarah'];
    $visi_misi = $_POST['visi_misi'];
    $struktur_organisasi = $_POST['struktur_organisasi'];
    
    $stmt = $pdo->prepare("UPDATE profil_desa SET nama_desa=?, alamat=?, telepon=?, email=?, sejarah=?, visi_misi=?, struktur_organisasi=? WHERE id=?");
    $stmt->execute([$nama_desa, $alamat, $telepon, $email, $sejarah, $visi_misi, $struktur_organisasi, $profil['id']]);
    
    $success = "Profil desa berhasil diperbarui!";
    // Refresh data
    $stmt = $pdo->query("SELECT * FROM profil_desa LIMIT 1");
    $profil = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Desa - Admin Desa Makmur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="../assets/css/admin.css" rel="stylesheet">
    
    <!-- TinyMCE Rich Text Editor -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.rich-text',
            plugins: 'advlist autolink lists link charmap preview anchor',
            toolbar_mode: 'floating',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
            height: 300,
            menubar: false,
            content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }'
        });
    </script>
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
                        <a class="nav-link active" href="profil.php">Profil Desa</a>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i><?= $_SESSION['nama_lengkap'] ?>
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
                            <a class="nav-link active" href="profil.php">
                                <i class="fas fa-info-circle me-2"></i>Profil Desa
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
                    <h1 class="h2">Edit Profil Desa</h1>
                    <a href="../pages/profil.php" target="_blank" class="btn btn-info">
                        <i class="fas fa-eye me-1"></i>Lihat di Website
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <h5 class="card-title mb-4">Informasi Umum</h5>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nama_desa" class="form-label">Nama Desa *</label>
                                    <input type="text" class="form-control" id="nama_desa" name="nama_desa" value="<?= $profil['nama_desa'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="telepon" class="form-label">Telepon *</label>
                                    <input type="text" class="form-control" id="telepon" name="telepon" value="<?= $profil['telepon'] ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat Lengkap *</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= $profil['alamat'] ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $profil['email'] ?>" required>
                            </div>

                            <hr class="my-4">

                            <h5 class="card-title mb-4">Konten Profil</h5>

                            <div class="mb-3">
                                <label for="sejarah" class="form-label">Sejarah Desa</label>
                                <textarea class="form-control rich-text" id="sejarah" name="sejarah" rows="8"><?= $profil['sejarah'] ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="visi_misi" class="form-label">Visi & Misi</label>
                                <textarea class="form-control rich-text" id="visi_misi" name="visi_misi" rows="8"><?= $profil['visi_misi'] ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="struktur_organisasi" class="form-label">Struktur Organisasi</label>
                                <textarea class="form-control rich-text" id="struktur_organisasi" name="struktur_organisasi" rows="8"><?= $profil['struktur_organisasi'] ?></textarea>
                                <div class="form-text">Gunakan format HTML untuk membuat tabel struktur organisasi</div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Tips Pengisian</h6>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li>Gunakan editor teks untuk memformat konten dengan rapi</li>
                            <li>Untuk struktur organisasi, buat tabel menggunakan fitur table di editor</li>
                            <li>Simpan perubahan secara berkala</li>
                            <li>Preview perubahan dengan mengklik "Lihat di Website"</li>
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
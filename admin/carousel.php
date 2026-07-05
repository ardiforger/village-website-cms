<?php
// admin/carousel.php
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

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Proses tambah/edit carousel
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = clean_input($_POST['judul']);
    $deskripsi = clean_input($_POST['deskripsi']);
    $urutan = (int)$_POST['urutan'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Handle gambar upload
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['gambar']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $extension = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
            $filename = 'carousel_' . time() . '.' . $extension;
            $upload_path = '../uploads/carousel/' . $filename;
            
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
                $gambar = $filename;
            }
        }
    }
    
    if ($action == 'tambah') {
        $stmt = $pdo->prepare("INSERT INTO carousel (judul, deskripsi, gambar, urutan, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$judul, $deskripsi, $gambar, $urutan, $is_active]);
        $success = "Slide carousel berhasil ditambahkan!";
    } elseif ($action == 'edit' && $id > 0) {
        if ($gambar) {
            $stmt = $pdo->prepare("UPDATE carousel SET judul=?, deskripsi=?, gambar=?, urutan=?, is_active=? WHERE id=?");
            $stmt->execute([$judul, $deskripsi, $gambar, $urutan, $is_active, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE carousel SET judul=?, deskripsi=?, urutan=?, is_active=? WHERE id=?");
            $stmt->execute([$judul, $deskripsi, $urutan, $is_active, $id]);
        }
        $success = "Slide carousel berhasil diperbarui!";
    }
}

// Proses hapus carousel
if (isset($_GET['delete']) && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM carousel WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: carousel.php?success=Slide carousel berhasil dihapus!');
    exit;
}

// Ambil data carousel untuk edit
$slide = null;
if ($action == 'edit' && $id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM carousel WHERE id = ?");
    $stmt->execute([$id]);
    $slide = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$slide) {
        header('Location: carousel.php');
        exit;
    }
}

// Ambil list carousel
$stmt = $pdo->query("SELECT * FROM carousel ORDER BY urutan, created_at DESC");
$carousel_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Carousel - Admin Desa Makmur</title>
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
                        <a class="nav-link active" href="carousel.php">Carousel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">Profil Desa</a>
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
                            <a class="nav-link active" href="carousel.php">
                                <i class="fas fa-sliders-h me-2"></i>Carousel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profil.php">
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

                <?php if(isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <?= $_GET['success'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if($action == 'list'): ?>
                <!-- List Carousel -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Carousel</h1>
                    <a href="?action=tambah" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Tambah Slide
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Urutan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($carousel_list): ?>
                                <?php foreach($carousel_list as $item): ?>
                                <tr>
                                    <td>
                                        <img src="../uploads/carousel/<?= $item['gambar'] ?>" alt="Carousel" style="width: 100px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td><?= $item['judul'] ?: '-' ?></td>
                                    <td><?= $item['deskripsi'] ? substr($item['deskripsi'], 0, 50) . '...' : '-' ?></td>
                                    <td><?= $item['urutan'] ?></td>
                                    <td>
                                        <span class="badge <?= $item['is_active'] ? 'bg-success' : 'bg-secondary' ?>">
                                            <?= $item['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="?action=edit&id=<?= $item['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?action=edit&id=<?= $item['id'] ?>&delete=1" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus slide ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-sliders-h fa-3x mb-3"></i><br>
                                        Belum ada slide carousel. <a href="?action=tambah">Tambah slide pertama</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php else: ?>
                <!-- Form Tambah/Edit Carousel -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?= $action == 'tambah' ? 'Tambah Slide Carousel' : 'Edit Slide Carousel' ?></h1>
                    <a href="carousel.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Slide</label>
                                <input type="text" class="form-control" id="judul" name="judul" value="<?= $slide ? $slide['judul'] : '' ?>">
                                <div class="form-text">Opsional, akan ditampilkan di carousel caption</div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= $slide ? $slide['deskripsi'] : '' ?></textarea>
                                <div class="form-text">Opsional, akan ditampilkan di carousel caption</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="urutan" class="form-label">Urutan Tampil</label>
                                    <input type="number" class="form-control" id="urutan" name="urutan" value="<?= $slide ? $slide['urutan'] : '0' ?>" min="0">
                                    <div class="form-text">Angka lebih kecil akan ditampilkan lebih dulu</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" <?= $slide && $slide['is_active'] ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="is_active">
                                            Aktif (ditampilkan di homepage)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar Slide *</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" <?= $action == 'tambah' ? 'required' : '' ?>>
                                <div class="form-text">Rekomendasi ukuran: 1200x500px format JPG/PNG</div>
                                <?php if($slide && $slide['gambar']): ?>
                                <div class="mt-2">
                                    <img src="../uploads/carousel/<?= $slide['gambar'] ?>" alt="Current slide" style="max-height: 200px;" class="img-thumbnail">
                                    <p class="text-muted small mt-1">Gambar saat ini</p>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="carousel.php" class="btn btn-secondary me-md-2">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    <?= $action == 'tambah' ? 'Simpan Slide' : 'Update Slide' ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
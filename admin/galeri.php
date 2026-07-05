<?php
// admin/galeri.php
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

// Proses tambah/edit galeri
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = clean_input($_POST['judul']);
    $deskripsi = clean_input($_POST['deskripsi']);
    $kategori = clean_input($_POST['kategori']);
    
    // Handle gambar upload
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['gambar']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $extension = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
            $filename = 'galeri_' . time() . '.' . $extension;
            $upload_path = '../uploads/galeri/' . $filename;
            
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
                $gambar = $filename;
            }
        }
    }
    
    if ($action == 'tambah') {
        $stmt = $pdo->prepare("INSERT INTO galeri (judul, deskripsi, gambar, kategori) VALUES (?, ?, ?, ?)");
        $stmt->execute([$judul, $deskripsi, $gambar, $kategori]);
        $success = "Foto berhasil ditambahkan ke galeri!";
    } elseif ($action == 'edit' && $id > 0) {
        if ($gambar) {
            $stmt = $pdo->prepare("UPDATE galeri SET judul=?, deskripsi=?, gambar=?, kategori=? WHERE id=?");
            $stmt->execute([$judul, $deskripsi, $gambar, $kategori, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE galeri SET judul=?, deskripsi=?, kategori=? WHERE id=?");
            $stmt->execute([$judul, $deskripsi, $kategori, $id]);
        }
        $success = "Foto berhasil diperbarui!";
    }
}

// Proses hapus galeri
if (isset($_GET['delete']) && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM galeri WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: galeri.php?success=Foto berhasil dihapus!');
    exit;
}

// Ambil data galeri untuk edit
$foto = null;
if ($action == 'edit' && $id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM galeri WHERE id = ?");
    $stmt->execute([$id]);
    $foto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$foto) {
        header('Location: galeri.php');
        exit;
    }
}

// Ambil list galeri
$stmt = $pdo->query("SELECT * FROM galeri ORDER BY created_at DESC");
$galeri_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Galeri - Admin Desa Makmur</title>
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
                        <a class="nav-link active" href="galeri.php">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="carousel.php">Carousel</a>
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
                            <a class="nav-link active" href="galeri.php">
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
                <!-- List Galeri -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Galeri Foto</h1>
                    <a href="?action=tambah" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Tambah Foto
                    </a>
                </div>

                <div class="row">
                    <?php if($galeri_list): ?>
                        <?php foreach($galeri_list as $item): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="../uploads/galeri/<?= $item['gambar'] ?>" class="card-img-top" alt="<?= $item['judul'] ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $item['judul'] ?></h5>
                                    <?php if($item['deskripsi']): ?>
                                    <p class="card-text"><?= $item['deskripsi'] ?></p>
                                    <?php endif; ?>
                                    <?php if($item['kategori']): ?>
                                    <span class="badge bg-primary"><?= $item['kategori'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">
                                        <?= date('d M Y', strtotime($item['created_at'])) ?>
                                    </small>
                                    <div class="float-end">
                                        <a href="?action=edit&id=<?= $item['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?action=edit&id=<?= $item['id'] ?>&delete=1" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus foto ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-images fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada foto di galeri.</p>
                            <a href="?action=tambah" class="btn btn-primary">Tambah Foto Pertama</a>
                        </div>
                    <?php endif; ?>
                </div>

                <?php else: ?>
                <!-- Form Tambah/Edit Galeri -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?= $action == 'tambah' ? 'Tambah Foto ke Galeri' : 'Edit Foto Galeri' ?></h1>
                    <a href="galeri.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Foto *</label>
                                <input type="text" class="form-control" id="judul" name="judul" value="<?= $foto ? $foto['judul'] : '' ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= $foto ? $foto['deskripsi'] : '' ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-select" id="kategori" name="kategori">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Kegiatan Desa" <?= $foto && $foto['kategori'] == 'Kegiatan Desa' ? 'selected' : '' ?>>Kegiatan Desa</option>
                                    <option value="Infrastruktur" <?= $foto && $foto['kategori'] == 'Infrastruktur' ? 'selected' : '' ?>>Infrastruktur</option>
                                    <option value="Alam" <?= $foto && $foto['kategori'] == 'Alam' ? 'selected' : '' ?>>Alam</option>
                                    <option value="Budaya" <?= $foto && $foto['kategori'] == 'Budaya' ? 'selected' : '' ?>>Budaya</option>
                                    <option value="Event" <?= $foto && $foto['kategori'] == 'Event' ? 'selected' : '' ?>>Event</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="gambar" class="form-label">Foto *</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" <?= $action == 'tambah' ? 'required' : '' ?>>
                                <?php if($foto && $foto['gambar']): ?>
                                <div class="mt-2">
                                    <img src="../uploads/galeri/<?= $foto['gambar'] ?>" alt="Current photo" style="max-height: 200px;" class="img-thumbnail">
                                    <p class="text-muted small mt-1">Foto saat ini</p>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="galeri.php" class="btn btn-secondary me-md-2">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    <?= $action == 'tambah' ? 'Simpan Foto' : 'Update Foto' ?>
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
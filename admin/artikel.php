<?php
// admin/artikel.php
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

// Proses tambah/edit berita
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = clean_input($_POST['judul']);
    $konten = $_POST['konten']; // Tidak di-clean karena HTML content
    $kategori = clean_input($_POST['kategori']);
    $status = clean_input($_POST['status']);
    
    // Generate slug dari judul
    $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $judul), '-'));
    
    // Handle thumbnail upload
    $thumbnail = null;
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['thumbnail']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $extension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
            $filename = 'berita_' . time() . '.' . $extension;
            $upload_path = '../uploads/artikel/' . $filename;
            
            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $upload_path)) {
                $thumbnail = $filename;
            }
        }
    }
    
    if ($action == 'tambah') {
        $stmt = $pdo->prepare("INSERT INTO berita (judul, slug, konten, thumbnail, kategori, status, penulis_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$judul, $slug, $konten, $thumbnail, $kategori, $status, $_SESSION['user_id']]);
        $success = "Berita berhasil ditambahkan!";
    } elseif ($action == 'edit' && $id > 0) {
        if ($thumbnail) {
            $stmt = $pdo->prepare("UPDATE berita SET judul=?, slug=?, konten=?, thumbnail=?, kategori=?, status=? WHERE id=?");
            $stmt->execute([$judul, $slug, $konten, $thumbnail, $kategori, $status, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE berita SET judul=?, slug=?, konten=?, kategori=?, status=? WHERE id=?");
            $stmt->execute([$judul, $slug, $konten, $kategori, $status, $id]);
        }
        $success = "Berita berhasil diperbarui!";
    }
}

// Proses hapus berita
if (isset($_GET['delete']) && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM berita WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: artikel.php?success=Berita berhasil dihapus!');
    exit;
}

// Ambil data berita untuk edit
$berita = null;
if ($action == 'edit' && $id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM berita WHERE id = ?");
    $stmt->execute([$id]);
    $berita = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$berita) {
        header('Location: artikel.php');
        exit;
    }
}

// Ambil list berita
$stmt = $pdo->query("SELECT b.*, u.nama_lengkap FROM berita b LEFT JOIN users u ON b.penulis_id = u.id ORDER BY b.created_at DESC");
$berita_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Berita - Admin Desa Makmur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="../assets/css/admin.css" rel="stylesheet">
    
    <!-- TinyMCE Rich Text Editor -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#konten',
            plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
            toolbar_mode: 'floating',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            height: 400,
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
                        <a class="nav-link active" href="artikel.php">Berita</a>
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
                            <a class="nav-link active" href="artikel.php">
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
                <!-- List Berita -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Berita</h1>
                    <a href="?action=tambah" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Tambah Berita
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Thumbnail</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Penulis</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($berita_list): ?>
                                <?php foreach($berita_list as $item): ?>
                                <tr>
                                    <td>
                                        <?php if($item['thumbnail']): ?>
                                        <img src="../uploads/artikel/<?= $item['thumbnail'] ?>" alt="Thumbnail" style="width: 60px; height: 40px; object-fit: cover;">
                                        <?php else: ?>
                                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 60px; height: 40px;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $item['judul'] ?></td>
                                    <td>
                                        <?php if($item['kategori']): ?>
                                        <span class="badge bg-info"><?= $item['kategori'] ?></span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary">Umum</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge <?= $item['status'] == 'publish' ? 'bg-success' : 'bg-warning' ?>">
                                            <?= $item['status'] == 'publish' ? 'Publish' : 'Draft' ?>
                                        </span>
                                    </td>
                                    <td><?= $item['nama_lengkap'] ?></td>
                                    <td><?= date('d M Y', strtotime($item['created_at'])) ?></td>
                                    <td>
                                        <a href="?action=edit&id=<?= $item['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?action=edit&id=<?= $item['id'] ?>&delete=1" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus berita ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="../pages/berita-detail.php?id=<?= $item['id'] ?>" target="_blank" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-newspaper fa-3x mb-3"></i><br>
                                        Belum ada berita. <a href="?action=tambah">Tambah berita pertama</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php else: ?>
                <!-- Form Tambah/Edit Berita -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?= $action == 'tambah' ? 'Tambah Berita' : 'Edit Berita' ?></h1>
                    <a href="artikel.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Berita *</label>
                                <input type="text" class="form-control" id="judul" name="judul" value="<?= $berita ? $berita['judul'] : '' ?>" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select class="form-select" id="kategori" name="kategori">
                                        <option value="">Pilih Kategori</option>
                                        <option value="Pemerintahan" <?= $berita && $berita['kategori'] == 'Pemerintahan' ? 'selected' : '' ?>>Pemerintahan</option>
                                        <option value="Ekonomi" <?= $berita && $berita['kategori'] == 'Ekonomi' ? 'selected' : '' ?>>Ekonomi</option>
                                        <option value="Pembangunan" <?= $berita && $berita['kategori'] == 'Pembangunan' ? 'selected' : '' ?>>Pembangunan</option>
                                        <option value="Sosial" <?= $berita && $berita['kategori'] == 'Sosial' ? 'selected' : '' ?>>Sosial</option>
                                        <option value="Kesehatan" <?= $berita && $berita['kategori'] == 'Kesehatan' ? 'selected' : '' ?>>Kesehatan</option>
                                        <option value="Pendidikan" <?= $berita && $berita['kategori'] == 'Pendidikan' ? 'selected' : '' ?>>Pendidikan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="draft" <?= $berita && $berita['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                                        <option value="publish" <?= $berita && $berita['status'] == 'publish' ? 'selected' : '' ?>>Publish</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="thumbnail" class="form-label">Thumbnail</label>
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                                <?php if($berita && $berita['thumbnail']): ?>
                                <div class="mt-2">
                                    <img src="../uploads/artikel/<?= $berita['thumbnail'] ?>" alt="Current thumbnail" style="max-height: 150px;" class="img-thumbnail">
                                    <p class="text-muted small mt-1">Thumbnail saat ini</p>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="konten" class="form-label">Konten Berita *</label>
                                <textarea class="form-control" id="konten" name="konten" rows="15" required><?= $berita ? $berita['konten'] : '' ?></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="artikel.php" class="btn btn-secondary me-md-2">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    <?= $action == 'tambah' ? 'Simpan Berita' : 'Update Berita' ?>
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
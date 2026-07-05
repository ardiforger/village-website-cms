<?php
// admin/users.php
include '../includes/config.php';
include '../includes/auth.php';
checkAuth();
checkRole(['admin']); // Hanya admin yang bisa akses

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Proses tambah/edit user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean_input($_POST['username']);
    $nama_lengkap = clean_input($_POST['nama_lengkap']);
    $email = clean_input($_POST['email']);
    $role = clean_input($_POST['role']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    if ($action == 'tambah') {
        $password = password_hash('password123', PASSWORD_DEFAULT); // Default password
        $stmt = $pdo->prepare("INSERT INTO users (username, password, email, nama_lengkap, role, is_active) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$username, $password, $email, $nama_lengkap, $role, $is_active]);
        $success = "User berhasil ditambahkan! Password default: password123";
    } elseif ($action == 'edit' && $id > 0) {
        $stmt = $pdo->prepare("UPDATE users SET username=?, email=?, nama_lengkap=?, role=?, is_active=? WHERE id=?");
        $stmt->execute([$username, $email, $nama_lengkap, $role, $is_active, $id]);
        $success = "User berhasil diperbarui!";
    }
}

// Proses reset password
if (isset($_GET['reset_password']) && $id > 0) {
    $password = password_hash('password123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password=? WHERE id=?");
    $stmt->execute([$password, $id]);
    header('Location: users.php?success=Password berhasil direset ke: password123');
    exit;
}

// Proses hapus user
if (isset($_GET['delete']) && $id > 0) {
    // Jangan hapus user sendiri
    if ($id != $_SESSION['user_id']) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: users.php?success=User berhasil dihapus!');
        exit;
    } else {
        header('Location: users.php?error=Tidak bisa menghapus akun sendiri!');
        exit;
    }
}

// Ambil data user untuk edit
$user = null;
if ($action == 'edit' && $id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        header('Location: users.php');
        exit;
    }
}

// Ambil list users
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Admin Desa Makmur</title>
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
                        <a class="nav-link" href="pengaturan.php">Pengaturan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="users.php">Manajemen User</a>
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
                            <a class="nav-link" href="pengaturan.php">
                                <i class="fas fa-cog me-2"></i>Pengaturan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="users.php">
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

                <?php if(isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <?= $_GET['success'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <?= $_GET['error'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if($action == 'list'): ?>
                <!-- List Users -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen User</h1>
                    <a href="?action=tambah" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Tambah User
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($users_list): ?>
                                <?php foreach($users_list as $item): ?>
                                <tr>
                                    <td><?= $item['username'] ?></td>
                                    <td><?= $item['nama_lengkap'] ?></td>
                                    <td><?= $item['email'] ?></td>
                                    <td>
                                        <span class="badge 
                                            <?= $item['role'] == 'admin' ? 'bg-danger' : '' ?>
                                            <?= $item['role'] == 'editor' ? 'bg-warning' : '' ?>
                                            <?= $item['role'] == 'author' ? 'bg-info' : '' ?>
                                        ">
                                            <?= ucfirst($item['role']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?= $item['is_active'] ? 'bg-success' : 'bg-secondary' ?>">
                                            <?= $item['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($item['created_at'])) ?></td>
                                    <td>
                                        <a href="?action=edit&id=<?= $item['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?action=edit&id=<?= $item['id'] ?>&reset_password=1" class="btn btn-sm btn-secondary" onclick="return confirm('Reset password user ini?')" title="Reset Password">
                                            <i class="fas fa-key"></i>
                                        </a>
                                        <?php if($item['id'] != $_SESSION['user_id']): ?>
                                        <a href="?action=edit&id=<?= $item['id'] ?>&delete=1" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus user ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <?php else: ?>
                                        <button class="btn btn-sm btn-danger" disabled title="Tidak bisa hapus akun sendiri">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-users fa-3x mb-3"></i><br>
                                        Belum ada user. <a href="?action=tambah">Tambah user pertama</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php else: ?>
                <!-- Form Tambah/Edit User -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?= $action == 'tambah' ? 'Tambah User Baru' : 'Edit User' ?></h1>
                    <a href="users.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="username" class="form-label">Username *</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?= $user ? $user['username'] : '' ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= $user ? $user['email'] : '' ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= $user ? $user['nama_lengkap'] : '' ?>" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="role" class="form-label">Role *</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="author" <?= $user && $user['role'] == 'author' ? 'selected' : '' ?>>Author (Bendahara)</option>
                                        <option value="editor" <?= $user && $user['role'] == 'editor' ? 'selected' : '' ?>>Editor (Sekretaris)</option>
                                        <option value="admin" <?= $user && $user['role'] == 'admin' ? 'selected' : '' ?>>Admin (Kepala Desa)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" <?= $user && $user['is_active'] ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="is_active">
                                            Akun Aktif
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <?php if($action == 'tambah'): ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Password default untuk user baru: <strong>password123</strong>
                            </div>
                            <?php endif; ?>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="users.php" class="btn btn-secondary me-md-2">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    <?= $action == 'tambah' ? 'Simpan User' : 'Update User' ?>
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
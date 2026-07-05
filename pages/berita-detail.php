<?php
// pages/profil.php
include '../includes/config.php';
include 'includes/header-pages.php'; // GANTI INI

if(!isset($_GET['id'])) {
    header('Location: berita.php');
    exit;
}

$id = (int)$_GET['id'];

// Ambil detail berita
$berita_query = $pdo->prepare("SELECT b.*, u.nama_lengkap FROM berita b 
                              LEFT JOIN users u ON b.penulis_id = u.id 
                              WHERE b.id = ? AND b.status = 'publish'");
$berita_query->execute([$id]);
$berita = $berita_query->fetch(PDO::FETCH_ASSOC);

if(!$berita) {
    header('Location: berita.php');
    exit;
}

// Update views
$update_views = $pdo->prepare("UPDATE berita SET views = views + 1 WHERE id = ?");
$update_views->execute([$id]);

// Ambil berita terkait
$related_query = $pdo->prepare("SELECT id, judul, thumbnail, created_at FROM berita 
                               WHERE status = 'publish' AND id != ? 
                               ORDER BY created_at DESC LIMIT 3");
$related_query->execute([$id]);
$related_news = $related_query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-5">
    <div class="row">
        <!-- Konten Berita -->
        <div class="col-lg-8">
            <article class="card shadow-sm">
                <?php if($berita['thumbnail']): ?>
                <img src="../uploads/artikel/<?= $berita['thumbnail'] ?>" class="card-img-top" alt="<?= $berita['judul'] ?>" style="max-height: 400px; object-fit: cover;">
                <?php endif; ?>
                
                <div class="card-body">
                    <h1 class="card-title text-primary"><?= $berita['judul'] ?></h1>
                    
                    <div class="d-flex flex-wrap align-items-center text-muted mb-4">
                        <div class="me-3">
                            <i class="fas fa-user me-1"></i> <?= $berita['nama_lengkap'] ?>
                        </div>
                        <div class="me-3">
                            <i class="fas fa-calendar me-1"></i> <?= date('d F Y', strtotime($berita['created_at'])) ?>
                        </div>
                        <div class="me-3">
                            <i class="fas fa-eye me-1"></i> <?= $berita['views'] ?> views
                        </div>
                        <?php if($berita['kategori']): ?>
                        <div>
                            <span class="badge bg-primary"><?= $berita['kategori'] ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="content">
                        <?= $berita['konten'] ?>
                    </div>
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Berita Terkait -->
            <?php if($related_news): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-newspaper me-2"></i>Berita Terkait</h5>
                </div>
                <div class="card-body">
                    <?php foreach($related_news as $related): ?>
                    <div class="mb-3 pb-3 border-bottom">
                        <h6 class="mb-1">
                            <a href="berita-detail.php?id=<?= $related['id'] ?>" class="text-decoration-none">
                                <?= $related['judul'] ?>
                            </a>
                        </h6>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i> <?= date('d M Y', strtotime($related['created_at'])) ?>
                        </small>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Info Desa -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Info Desa</h5>
                </div>
                <div class="card-body">
                    <p><strong>Desa Makmur</strong> adalah desa yang terletak di Kecamatan Sajahiera, Kabupaten Makmur Jaya. Desa ini dikenal dengan masyarakatnya yang ramah dan potensi alamnya yang melimpah.</p>
                    <a href="../pages/profil.php" class="btn btn-outline-success btn-sm">Profil Lengkap</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.content img {
    max-width: 100%;
    height: auto;
    margin: 1rem 0;
}

.content p {
    line-height: 1.8;
    margin-bottom: 1rem;
}

.content h2, .content h3, .content h4 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    color: var(--primary-color);
}
</style>

<?php include 'includes/footer-pages.php'; ?>
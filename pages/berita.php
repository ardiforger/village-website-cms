<?php
// pages/berita.php
include '../includes/config.php';
include 'includes/header-pages.php';

// Pagination
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Hitung total berita
$total_query = $pdo->query("SELECT COUNT(*) FROM berita WHERE status = 'publish'");
$total_berita = $total_query->fetchColumn();
$total_pages = ceil($total_berita / $limit);

// Ambil berita dengan pagination
$berita_query = $pdo->prepare("SELECT b.*, u.nama_lengkap FROM berita b 
                              LEFT JOIN users u ON b.penulis_id = u.id 
                              WHERE b.status = 'publish' 
                              ORDER BY b.created_at DESC 
                              LIMIT :limit OFFSET :offset");
$berita_query->bindValue(':limit', $limit, PDO::PARAM_INT);
$berita_query->bindValue(':offset', $offset, PDO::PARAM_INT);
$berita_query->execute();
$berita_list = $berita_query->fetchAll(PDO::FETCH_ASSOC);

// Ambil berita populer (berdasarkan views)
$populer_query = $pdo->query("SELECT id, judul, thumbnail, views FROM berita 
                             WHERE status = 'publish' 
                             ORDER BY views DESC LIMIT 5");
$berita_populer = $populer_query->fetchAll(PDO::FETCH_ASSOC);

// Ambil kategori berita
$kategori_query = $pdo->query("SELECT DISTINCT kategori FROM berita WHERE kategori IS NOT NULL AND status = 'publish'");
$kategori_list = $kategori_query->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="container py-4">
    <div class="row">
        <!-- Konten Utama -->
        <div class="col-lg-8">
            <!-- Header Berita -->
            <div class="mb-4">
                <h1 class="h2 fw-bold text-primary mb-2">Berita Terkini</h1>
                <p class="text-muted">Informasi dan perkembangan terbaru dari Desa Makmur</p>
            </div>

            <!-- List Berita -->
            <div class="row">
                <?php if($berita_list): ?>
                    <?php foreach($berita_list as $berita): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm h-100 news-card">
                            <?php if($berita['thumbnail']): ?>
                            <img src="../uploads/artikel/<?= $berita['thumbnail'] ?>" class="card-img-top" alt="<?= $berita['judul'] ?>" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-newspaper fa-3x text-muted"></i>
                            </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <?php if($berita['kategori']): ?>
                                <span class="badge bg-primary mb-2"><?= $berita['kategori'] ?></span>
                                <?php endif; ?>
                                <h5 class="card-title fw-bold">
                                    <a href="berita-detail.php?id=<?= $berita['id'] ?>" class="text-dark text-decoration-none">
                                        <?= $berita['judul'] ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted small">
                                    <i class="fas fa-user me-1"></i> <?= $berita['nama_lengkap'] ?>
                                    <i class="fas fa-calendar ms-2 me-1"></i> <?= date('d M Y', strtotime($berita['created_at'])) ?>
                                    <i class="fas fa-eye ms-2 me-1"></i> <?= $berita['views'] ?>
                                </p>
                                <p class="card-text"><?= substr(strip_tags($berita['konten']), 0, 120) ?>...</p>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="berita-detail.php?id=<?= $berita['id'] ?>" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum ada berita</h4>
                        <p class="text-muted">Silakan kembali lagi nanti untuk informasi terbaru.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if($total_pages > 1): ?>
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">Sebelumnya</a>
                    </li>
                    <?php endif; ?>

                    <?php 
                    $start_page = max(1, $page - 2);
                    $end_page = min($total_pages, $page + 2);
                    
                    for($i = $start_page; $i <= $end_page; $i++): 
                    ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Selanjutnya</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Berita Populer -->
            <?php if($berita_populer): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-fire me-2"></i>Berita Populer</h5>
                </div>
                <div class="card-body">
                    <?php foreach($berita_populer as $populer): ?>
                    <div class="mb-3 pb-3 border-bottom">
                        <h6 class="mb-1">
                            <a href="berita-detail.php?id=<?= $populer['id'] ?>" class="text-decoration-none text-dark">
                                <?= $populer['judul'] ?>
                            </a>
                        </h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-eye me-1"></i> <?= $populer['views'] ?> views
                            </small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Kategori -->
            <?php if($kategori_list): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Kategori Berita</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach($kategori_list as $kategori): ?>
                        <a href="berita.php?kategori=<?= urlencode($kategori) ?>" class="badge bg-light text-dark text-decoration-none">
                            <?= $kategori ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Info Desa -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Tentang Desa Makmur</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Desa Makmur adalah desa yang terletak di Kecamatan Sajahiera, Kabupaten Makmur Jaya. Desa ini dikenal dengan masyarakatnya yang ramah dan potensi alamnya yang melimpah.</p>
                    <a href="profil.php" class="btn btn-outline-info btn-sm">Profil Lengkap</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.news-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.card-title a {
    transition: color 0.3s ease;
}

.card-title a:hover {
    color: var(--primary-color) !important;
}

.page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.page-link {
    color: var(--primary-color);
}

.page-link:hover {
    color: var(--primary-color);
}
</style>

<?php include 'includes/footer-pages.php'; ?>
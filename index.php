<?php
// index.php
include 'includes/config.php';
include 'includes/header.php';

// Ambil data carousel aktif (limit 3)
$carousel_query = $pdo->query("SELECT * FROM carousel WHERE is_active = 1 ORDER BY urutan LIMIT 3");
$carousels = $carousel_query->fetchAll(PDO::FETCH_ASSOC);

// Ambil berita terbaru
$berita_query = $pdo->query("SELECT b.*, u.nama_lengkap FROM berita b 
                            LEFT JOIN users u ON b.penulis_id = u.id 
                            WHERE b.status = 'publish' 
                            ORDER BY b.created_at DESC LIMIT 3");
$berita_terbaru = $berita_query->fetchAll(PDO::FETCH_ASSOC);

// Data statistik dinamis (contoh - bisa diganti dengan data dari database)
$statistik = [
    'penduduk' => '2,500+',
    'luas_wilayah' => '500 Ha', 
    'dusun' => '4',
    'kepala_keluarga' => '650'
];
?>

<!-- Carousel Full Width - 3 Slide -->
<?php if($carousels): ?>
<div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php foreach($carousels as $key => $carousel): ?>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="<?= $key ?>" 
                class="<?= $key === 0 ? 'active' : '' ?>" aria-current="<?= $key === 0 ? 'true' : 'false' ?>" 
                aria-label="Slide <?= $key + 1 ?>"></button>
        <?php endforeach; ?>
    </div>
    <div class="carousel-inner">
        <?php foreach($carousels as $key => $carousel): ?>
        <div class="carousel-item <?= $key === 0 ? 'active' : '' ?>">
            <img src="uploads/carousel/<?= $carousel['gambar'] ?>" class="d-block w-100" alt="<?= $carousel['judul'] ?>" style="height: 500px; object-fit: cover;">
            <?php if($carousel['judul'] || $carousel['deskripsi']): ?>
            <div class="carousel-caption d-none d-md-block">
                <?php if($carousel['judul']): ?>
                <h3><?= $carousel['judul'] ?></h3>
                <?php endif; ?>
                <?php if($carousel['deskripsi']): ?>
                <p><?= $carousel['deskripsi'] ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<?php else: ?>
<!-- Default Carousel jika belum ada data -->
<div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="assets/images/carousel/slide1.jpg" class="d-block w-100" alt="Slide 1" style="height: 500px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
                <h3>Selamat Datang di Desa Makmur</h3>
                <p>Desa yang makmur dan sejahtera</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/images/carousel/slide2.jpg" class="d-block w-100" alt="Slide 2" style="height: 500px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
                <h3>Potensi Alam yang Melimpah</h3>
                <p>Mengembangkan sumber daya alam secara berkelanjutan</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/images/carousel/slide3.jpg" class="d-block w-100" alt="Slide 3" style="height: 500px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
                <h3>Masyarakat yang Berbudaya</h3>
                <p>Menjaga adat dan tradisi lokal</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<?php endif; ?>

<!-- Statistik Desa - Data Dinamis -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                        <h3 class="text-primary"><?= $statistik['penduduk'] ?></h3>
                        <p class="mb-0 fw-bold">Jiwa Penduduk</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="fas fa-map fa-3x text-primary mb-3"></i>
                        <h3 class="text-primary"><?= $statistik['luas_wilayah'] ?></h3>
                        <p class="mb-0 fw-bold">Luas Wilayah</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="fas fa-home fa-3x text-primary mb-3"></i>
                        <h3 class="text-primary"><?= $statistik['dusun'] ?></h3>
                        <p class="mb-0 fw-bold">Dusun</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="fas fa-house-user fa-3x text-primary mb-3"></i>
                        <h3 class="text-primary"><?= $statistik['kepala_keluarga'] ?></h3>
                        <p class="mb-0 fw-bold">Kepala Keluarga</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hero Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold text-primary mb-3">Website Resmi Desa Makmur</h1>
                <p class="lead mb-4">Selamat datang di website resmi Pemerintah Desa Makmur. Media informasi dan komunikasi antara Pemerintah Desa dengan masyarakat.</p>
                
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-landmark fa-2x text-primary me-3 mt-1"></i>
                            <div>
                                <h5>Profil Desa</h5>
                                <p class="mb-2">Kenali lebih dalam tentang Desa Makmur, sejarah, dan visi misi pemerintahan.</p>
                                <a href="pages/profil.php" class="btn btn-primary btn-sm">Lihat Profil</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-concierge-bell fa-2x text-primary me-3 mt-1"></i>
                            <div>
                                <h5>Layanan Publik</h5>
                                <p class="mb-2">Informasi layanan publik yang disediakan oleh Pemerintah Desa Makmur.</p>
                                <a href="pages/layanan.php" class="btn btn-primary btn-sm">Lihat Layanan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <img src="assets/images/desa-illustration.png" alt="Ilustrasi Desa" class="img-fluid" style="max-height: 300px;">
            </div>
        </div>
    </div>
</section>

<!-- Berita Terbaru -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h2 class="text-center mb-3">Berita Terbaru</h2>
                <p class="text-center text-muted">Informasi dan berita terkini dari Desa Makmur</p>
            </div>
        </div>
        <div class="row">
            <?php if($berita_terbaru): ?>
                <?php foreach($berita_terbaru as $berita): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if($berita['thumbnail']): ?>
                        <img src="uploads/artikel/<?= $berita['thumbnail'] ?>" class="card-img-top" alt="<?= $berita['judul'] ?>" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-newspaper fa-3x text-white"></i>
                        </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= $berita['judul'] ?></h5>
                            <p class="card-text text-muted small">
                                <i class="fas fa-user"></i> <?= $berita['nama_lengkap'] ?> 
                                <i class="fas fa-calendar ms-2"></i> <?= date('d M Y', strtotime($berita['created_at'])) ?>
                            </p>
                            <p class="card-text"><?= substr(strip_tags($berita['konten']), 0, 100) ?>...</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="pages/berita-detail.php?id=<?= $berita['id'] ?>" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>Belum ada berita yang dipublikasikan.
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="row mt-4">
            <div class="col text-center">
                <a href="pages/berita.php" class="btn btn-primary">Lihat Semua Berita</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php
// pages/profil.php
include '../includes/config.php';
include 'includes/header-pages.php'; // GANTI INI

// Ambil semua kategori galeri
$kategori_query = $pdo->query("SELECT DISTINCT kategori FROM galeri WHERE kategori IS NOT NULL");
$kategori_list = $kategori_query->fetchAll(PDO::FETCH_COLUMN);

// Filter kategori
$kategori_filter = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Query galeri dengan filter
if($kategori_filter) {
    $galeri_query = $pdo->prepare("SELECT * FROM galeri WHERE kategori = ? ORDER BY created_at DESC");
    $galeri_query->execute([$kategori_filter]);
} else {
    $galeri_query = $pdo->query("SELECT * FROM galeri ORDER BY created_at DESC");
}
$galeri_list = $galeri_query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="text-primary">Galeri Desa</h1>
            <p class="lead">Dokumentasi kegiatan dan potensi Desa Makmur</p>
        </div>
    </div>

    <!-- Filter Kategori -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filter Kategori</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="?kategori=" class="btn btn-outline-primary <?= !$kategori_filter ? 'active' : '' ?>">
                            Semua Kategori
                        </a>
                        <?php foreach($kategori_list as $kategori): ?>
                        <a href="?kategori=<?= urlencode($kategori) ?>" class="btn btn-outline-primary <?= $kategori_filter == $kategori ? 'active' : '' ?>">
                            <?= $kategori ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Galeri Foto -->
    <div class="row">
        <?php if($galeri_list): ?>
            <?php foreach($galeri_list as $foto): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="../uploads/galeri/<?= $foto['gambar'] ?>" class="card-img-top" alt="<?= $foto['judul'] ?>" style="height: 250px; object-fit: cover; cursor: pointer;" 
                         data-bs-toggle="modal" data-bs-target="#modalGaleri" 
                         onclick="openModal('<?= $foto['judul'] ?>', '<?= $foto['deskripsi'] ?>', '../uploads/galeri/<?= $foto['gambar'] ?>')">
                    <div class="card-body">
                        <h5 class="card-title"><?= $foto['judul'] ?></h5>
                        <?php if($foto['deskripsi']): ?>
                        <p class="card-text"><?= $foto['deskripsi'] ?></p>
                        <?php endif; ?>
                        <?php if($foto['kategori']): ?>
                        <span class="badge bg-primary"><?= $foto['kategori'] ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i> <?= date('d M Y', strtotime($foto['created_at'])) ?>
                        </small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Belum ada foto dalam galeri.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal untuk Preview Gambar -->
<div class="modal fade" id="modalGaleri" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Judul Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" alt="" class="img-fluid" id="modalImage">
                <p class="mt-3" id="modalDescription"></p>
            </div>
        </div>
    </div>
</div>

<script>
function openModal(title, description, imageSrc) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = description;
    document.getElementById('modalImage').src = imageSrc;
}
</script>

<?php include 'includes/footer-pages.php'; ?>
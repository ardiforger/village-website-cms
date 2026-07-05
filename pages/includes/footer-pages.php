<?php
// pages/includes/footer-pages.php
$pengaturan_query = $pdo->query("SELECT * FROM pengaturan");
$pengaturan = [];
while($row = $pengaturan_query->fetch(PDO::FETCH_ASSOC)) {
    $pengaturan[$row['nama_setting']] = $row['nilai_setting'];
}
?>
    <!-- Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Desa Makmur</h5>
                    <p>Website resmi Pemerintah Desa Makmur. Media informasi dan komunikasi antara Pemerintah Desa dengan masyarakat.</p>
                    <div class="social-links">
                        <a href="<?= $pengaturan['social_facebook'] ?>" class="text-light me-3" target="_blank"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="<?= $pengaturan['social_instagram'] ?>" class="text-light me-3" target="_blank"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="<?= $pengaturan['social_youtube'] ?>" class="text-light" target="_blank"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Kontak Kami</h5>
                    <p>
                        <i class="fas fa-map-marker-alt me-2"></i> Kecamatan Sajahiera - Kabupaten Makmur Jaya<br>
                        <i class="fas fa-phone me-2"></i> (021) 1234-5678<br>
                        <i class="fas fa-envelope me-2"></i> desamakmur@email.com
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Link Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="../index.php" class="text-light text-decoration-none">Beranda</a></li>
                        <li><a href="profil.php" class="text-light text-decoration-none">Profil Desa</a></li>
                        <li><a href="berita.php" class="text-light text-decoration-none">Berita</a></li>
                        <li><a href="galeri.php" class="text-light text-decoration-none">Galeri</a></li>
                        <li><a href="kontak.php" class="text-light text-decoration-none">Kontak</a></li>
                    </ul>
                </div>
            </div>
            <hr class="bg-light">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-0">&copy; <?= date('Y') ?> Desa Makmur. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="../assets/js/script.js"></script>
</body>
</html>
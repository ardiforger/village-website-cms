<?php
// pages/profil.php
include '../includes/config.php';
include 'includes/header-pages.php'; // GANTI INI

// Ambil data profil untuk kontak
$profil_query = $pdo->query("SELECT * FROM profil_desa LIMIT 1");
$profil = $profil_query->fetch(PDO::FETCH_ASSOC);

// Ambil pengaturan WhatsApp
$whatsapp_query = $pdo->query("SELECT nilai_setting FROM pengaturan WHERE nama_setting = 'whatsapp_number'");
$whatsapp_number = $whatsapp_query->fetchColumn();

// Proses form kontak
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = clean_input($_POST['nama']);
    $email = clean_input($_POST['email']);
    $telepon = clean_input($_POST['telepon']);
    $subjek = clean_input($_POST['subjek']);
    $pesan = clean_input($_POST['pesan']);

    // Simpan ke database
    $stmt = $pdo->prepare("INSERT INTO kontak (nama, email, telepon, subjek, pesan) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $email, $telepon, $subjek, $pesan]);

    $success = "Pesan Anda telah terkirim. Kami akan membalasnya segera.";
}
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="text-primary">Kontak Kami</h1>
            <p class="lead">Hubungi kami untuk informasi lebih lanjut</p>
        </div>
    </div>

    <div class="row">
        <!-- Informasi Kontak -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Alamat Kantor</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <strong>Kantor Desa Makmur</strong><br>
                        Jl. Desa Makmur No. 123<br>
                        Kecamatan Sajahiera<br>
                        Kabupaten Makmur Jaya<br>
                        Kode Pos: 12345
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Kontak</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <strong>Telepon:</strong><br>
                        <i class="fas fa-phone me-2"></i><?= $profil['telepon'] ?><br><br>
                        
                        <strong>Email:</strong><br>
                        <i class="fas fa-envelope me-2"></i><?= $profil['email'] ?><br><br>
                        
                        <strong>WhatsApp:</strong><br>
                        <i class="fab fa-whatsapp me-2"></i><?= $whatsapp_number ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Jam Layanan</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <strong>Senin - Kamis:</strong><br>
                        08.00 - 15.00 WIB<br><br>
                        
                        <strong>Jumat:</strong><br>
                        08.00 - 11.30 WIB<br><br>
                        
                        <strong>Sabtu:</strong><br>
                        08.00 - 13.00 WIB<br><br>
                        
                        <strong>Minggu & Tanggal Merah:</strong><br>
                        Tutup
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Form Kontak -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-paper-plane me-2"></i>Kirim Pesan</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label">Nomor Telepon/WhatsApp</label>
                                <input type="tel" class="form-control" id="telepon" name="telepon">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subjek" class="form-label">Subjek *</label>
                                <input type="text" class="form-control" id="subjek" name="subjek" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan *</label>
                            <textarea class="form-control" id="pesan" name="pesan" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- WhatsApp Quick Action -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fab fa-whatsapp me-2"></i>WhatsApp Quick Chat</h5>
                </div>
                <div class="card-body text-center">
                    <i class="fab fa-whatsapp fa-4x text-success mb-3"></i>
                    <p>Butuh bantuan cepat? Hubungi kami via WhatsApp</p>
                    <a href="https://wa.me/<?= $whatsapp_number ?>?text=Halo%20Admin%20Desa%20Makmur,%20saya%20ingin%20bertanya..." 
                       class="btn btn-success" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i>Chat via WhatsApp
                    </a>
                </div>
            </div>

            <!-- Map -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-map me-2"></i>Lokasi Kantor</h5>
                </div>
                <div class="card-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.800344439849!2d107.61878647483196!3d-6.917379067445202!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6c2c8ebb36d%3A0x5f43b8e6e11e2b2b!2sBandung!5e0!3m2!1sen!2sid!4v1620000000000!5m2!1sen!2sid" 
                            width="100%" 
                            height="200" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer-pages.php'; ?>
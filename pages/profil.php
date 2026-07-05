<?php
// pages/profil.php
include '../includes/config.php';
include 'includes/header-pages.php'; // GANTI INI

$section = isset($_GET['section']) ? $_GET['section'] : 'sejarah';

// Ambil data profil desa
$profil_query = $pdo->query("SELECT * FROM profil_desa LIMIT 1");
$profil = $profil_query->fetch(PDO::FETCH_ASSOC);
?>

<div class="container py-5">
    <div class="row">
        <!-- Sidebar Profil -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Profil Desa</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="?section=sejarah" class="list-group-item list-group-item-action <?= $section == 'sejarah' ? 'active' : '' ?>">
                        <i class="fas fa-history me-2"></i>Sejarah Desa
                    </a>
                    <a href="?section=visi-misi" class="list-group-item list-group-item-action <?= $section == 'visi-misi' ? 'active' : '' ?>">
                        <i class="fas fa-bullseye me-2"></i>Visi & Misi
                    </a>
                    <a href="?section=struktur" class="list-group-item list-group-item-action <?= $section == 'struktur' ? 'active' : '' ?>">
                        <i class="fas fa-sitemap me-2"></i>Struktur Organisasi
                    </a>
                    <a href="?section=pemerintahan" class="list-group-item list-group-item-action <?= $section == 'pemerintahan' ? 'active' : '' ?>">
                        <i class="fas fa-landmark me-2"></i>Pemerintahan
                    </a>
                    <a href="?section=wilayah" class="list-group-item list-group-item-action <?= $section == 'wilayah' ? 'active' : '' ?>">
                        <i class="fas fa-map me-2"></i>Wilayah & Demografi
                    </a>
                </div>
            </div>
        </div>

        <!-- Konten Profil -->
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0 text-primary">
                        <?php
                        $judul_section = [
                            'sejarah' => 'Sejarah Desa Makmur',
                            'visi-misi' => 'Visi & Misi Desa Makmur',
                            'struktur' => 'Struktur Organisasi',
                            'pemerintahan' => 'Pemerintahan Desa',
                            'wilayah' => 'Wilayah & Demografi'
                        ];
                        echo $judul_section[$section];
                        ?>
                    </h4>
                </div>
                <div class="card-body">
                    <?php if($section == 'sejarah'): ?>
                        <div class="text-center mb-4">
                            <img src="../assets/images/sejarah-desa.jpg" alt="Sejarah Desa" class="img-fluid rounded" style="max-height: 300px;">
                        </div>
                        <p class="lead"><?= $profil['sejarah'] ?: 'Sejarah Desa Makmur akan diisi di sini...' ?></p>
                        
                    <?php elseif($section == 'visi-misi'): ?>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Visi</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><?= $profil['visi_misi'] ?: 'Visi Desa Makmur akan diisi di sini...' ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border-success">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0"><i class="fas fa-bullseye me-2"></i>Misi</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-check text-success me-2"></i>Meningkatkan pelayanan publik</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Membangun infrastruktur desa</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Mengembangkan potensi ekonomi</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Melestarikan budaya dan adat</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <?php elseif($section == 'struktur'): ?>
                        <div class="text-center">
                            <img src="../assets/images/struktur-organisasi.png" alt="Struktur Organisasi" class="img-fluid rounded shadow">
                        </div>
                        <div class="mt-4">
                            <h5>Struktur Pemerintahan Desa Makmur</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Jabatan</th>
                                            <th>Nama</th>
                                            <th>Tugas & Fungsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Kepala Desa</td>
                                            <td>Budi Santoso</td>
                                            <td>Pemimpin tertinggi desa</td>
                                        </tr>
                                        <tr>
                                            <td>Sekretaris Desa</td>
                                            <td>Siti Aminah</td>
                                            <td>Membantu kepala desa</td>
                                        </tr>
                                        <tr>
                                            <td>Bendahara</td>
                                            <td>Agus Wijaya</td>
                                            <td>Mengelola keuangan desa</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    <?php elseif($section == 'pemerintahan'): ?>
                        <h5>Struktur Pemerintahan Desa</h5>
                        <p>Desa Makmur dipimpin oleh seorang Kepala Desa yang dibantu oleh perangkat desa dan BPD (Badan Permusyawaratan Desa).</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-tie fa-3x text-primary mb-3"></i>
                                        <h5>Kepala Desa</h5>
                                        <p class="mb-1">Budi Santoso</p>
                                        <small class="text-muted">Masa Jabatan: 2021-2027</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-users fa-3x text-success mb-3"></i>
                                        <h5>BPD</h5>
                                        <p class="mb-1">9 Anggota</p>
                                        <small class="text-muted">Badan Permusyawaratan Desa</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <?php elseif($section == 'wilayah'): ?>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Batas Wilayah</h5>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong>Utara:</strong> Desa Sejahtera
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Timur:</strong> Desa Sentosa
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Selatan:</strong> Kecamatan Indah
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Barat:</strong> Sungai Makmur
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>Data Demografi</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Luas Wilayah</td>
                                            <td>500 Ha</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Penduduk</td>
                                            <td>2,500 Jiwa</td>
                                        </tr>
                                        <tr>
                                            <td>Kepala Keluarga</td>
                                            <td>650 KK</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Dusun</td>
                                            <td>4 Dusun</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer-pages.php'; ?>
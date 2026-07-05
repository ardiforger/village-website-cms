<?php
// pages/profil.php
include '../includes/config.php';
include 'includes/header-pages.php'; // GANTI INI
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="text-primary">Layanan Publik</h1>
            <p class="lead">Berbagai layanan yang disediakan oleh Pemerintah Desa Makmur untuk masyarakat</p>
        </div>
    </div>

    <div class="row">
        <!-- Kartu Layanan -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="icon-service mb-3">
                        <i class="fas fa-id-card fa-3x text-primary"></i>
                    </div>
                    <h4 class="card-title">Surat Keterangan</h4>
                    <p class="card-text">Pelayanan pembuatan surat keterangan domisili, tidak mampu, dan surat keterangan lainnya.</p>
                    <div class="mt-3">
                        <span class="badge bg-success">Online</span>
                        <span class="badge bg-info">Gratis</span>
                    </div>
                </div>
                <div class="card-footer bg-transparent text-center">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSurat">
                        Info Selengkapnya
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="icon-service mb-3">
                        <i class="fas fa-home fa-3x text-primary"></i>
                    </div>
                    <h4 class="card-title">Izin Mendirikan Bangunan</h4>
                    <p class="card-text">Pelayanan perizinan mendirikan bangunan untuk rumah tinggal dan usaha.</p>
                    <div class="mt-3">
                        <span class="badge bg-warning text-dark">Proses 3-7 Hari</span>
                    </div>
                </div>
                <div class="card-footer bg-transparent text-center">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalIMB">
                        Info Selengkapnya
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="icon-service mb-3">
                        <i class="fas fa-hand-holding-usd fa-3x text-primary"></i>
                    </div>
                    <h4 class="card-title">Bantuan Sosial</h4>
                    <p class="card-text">Pendaftaran dan verifikasi penerima bantuan sosial dari pemerintah.</p>
                    <div class="mt-3">
                        <span class="badge bg-success">Gratis</span>
                    </div>
                </div>
                <div class="card-footer bg-transparent text-center">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBansos">
                        Info Selengkapnya
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="icon-service mb-3">
                        <i class="fas fa-file-contract fa-3x text-primary"></i>
                    </div>
                    <h4 class="card-title">Administrasi Kependudukan</h4>
                    <p class="card-text">Pelayanan administrasi kependudukan seperti KK, KTP, dan akta kelahiran.</p>
                    <div class="mt-3">
                        <span class="badge bg-success">Online</span>
                    </div>
                </div>
                <div class="card-footer bg-transparent text-center">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdmin">
                        Info Selengkapnya
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="icon-service mb-3">
                        <i class="fas fa-handshake fa-3x text-primary"></i>
                    </div>
                    <h4 class="card-title">Mediasi & Konsultasi</h4>
                    <p class="card-text">Layanan mediasi perselisihan dan konsultasi masalah kemasyarakatan.</p>
                    <div class="mt-3">
                        <span class="badge bg-success">Gratis</span>
                    </div>
                </div>
                <div class="card-footer bg-transparent text-center">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMediasi">
                        Info Selengkapnya
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="icon-service mb-3">
                        <i class="fas fa-seedling fa-3x text-primary"></i>
                    </div>
                    <h4 class="card-title">Pertanian & Perkebunan</h4>
                    <p class="card-text">Konsultasi dan bantuan teknis untuk pengembangan pertanian dan perkebunan.</p>
                    <div class="mt-3">
                        <span class="badge bg-info">Bimbingan Teknis</span>
                    </div>
                </div>
                <div class="card-footer bg-transparent text-center">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPertanian">
                        Info Selengkapnya
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Layanan Tambahan -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <h4 class="text-primary"><i class="fas fa-info-circle me-2"></i>Informasi Penting</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Jam Layanan:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-clock me-2 text-primary"></i>Senin - Kamis: 08.00 - 15.00 WIB</li>
                                <li><i class="fas fa-clock me-2 text-primary"></i>Jumat: 08.00 - 11.30 WIB</li>
                                <li><i class="fas fa-clock me-2 text-primary"></i>Sabtu: 08.00 - 13.00 WIB</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Persyaratan Umum:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check me-2 text-success"></i>KTP Asli</li>
                                <li><i class="fas fa-check me-2 text-success"></i>Kartu Keluarga</li>
                                <li><i class="fas fa-check me-2 text-success"></i>Mengisi Formulir</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Detail Layanan -->
<div class="modal fade" id="modalSurat" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Surat Keterangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Jenis Surat:</h6>
                <ul>
                    <li>Surat Keterangan Domisili</li>
                    <li>Surat Keterangan Tidak Mampu</li>
                    <li>Surat Keterangan Usaha</li>
                    <li>Surat Keterangan Kelahiran</li>
                    <li>Surat Keterangan Kematian</li>
                </ul>
                <h6>Persyaratan:</h6>
                <ul>
                    <li>Fotokopi KTP</li>
                    <li>Fotokopi Kartu Keluarga</li>
                    <li>Mengisi formulir permohonan</li>
                </ul>
                <p class="text-muted"><small>Proses: 1-2 hari kerja</small></p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer-pages.php'; ?>
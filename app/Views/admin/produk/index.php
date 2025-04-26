<?= $this->extend('templates/admin') ?>

<?= $this->section('title') ?>
Data Produk
<?= $this->endSection()?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('assets/libs/datatables/dataTables.bootstrap5.min.css') ?>">
<?= $this->endSection()?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Data Produk Batik Tulis Brebes</h3>
        <a href="<?= base_url('admin/produk/tambah') ?>" class="btn btn-primary">
            <i class="ti ti-plus me-2"></i>Tambah Data
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="produkTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Produk</th>
                            <th>Foto Produk</th>
                            <th>Motif</th>
                            <th>Harga</th>
                            <th>Pembuat</th>
                            <th>Tgl Pembuatan</th>
                            <th>QR Code</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($produk as $item): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= esc($item['kode_asli']) ?></td>
                            <td>
                                <?php if($item['foto_produk_path']): ?>
                                    <img src="<?= base_url($item['foto_produk_path']) ?>" alt="Foto Produk" width="100">
                                <?php else: ?>
                                    <span class="badge bg-warning">Tidak ada foto</span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($item['motif']) ?></td>
                            <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                            <td><?= esc($item['nama_pembuat']) ?></td>
                            <td><?= date('d/m/Y', strtotime($item['tanggal_produksi'])) ?></td>
                            <td>
                                <?php if($item['qr_code_path']): ?>
                                    <img src="<?= base_url($item['qr_code_path']) ?>" alt="QR Code" width="100">
                                <?php else: ?>
                                    <span class="badge bg-warning">Belum digenerate</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/produk/edit/' . $item['id']) ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <a href="<?= base_url('admin/produk/hapus/' . $item['id']) ?>" 
                                   class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                    <i class="ti ti-trash"></i>
                                </a>
                                <a href="<?= base_url($item['qr_code_path']) ?>" download="<?= basename($item['qr_code_path']) ?>" class="btn btn-sm btn-outline-secondary">
                                    <i class="ti ti-download"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
    <script src="<?= base_url('assets/libs/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/libs/datatables/dataTables.bootstrap5.min.js') ?>"></script>
    <script>
        $(document).ready(function() {
            $('#produkTable').DataTable();
        });
    </script>
<?= $this->endSection() ?>
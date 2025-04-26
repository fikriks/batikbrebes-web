<?= $this->extend('templates/admin') ?>

<?= $this->section('title') ?>
Tambah Data Produk
<?= $this->endSection()?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Tambah Data Produk</h3>
        <a href="<?= base_url('admin/produk') ?>" class="btn btn-secondary">
            <i class="ti ti-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('admin/produk/simpan') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kode Produk <span class="text-danger">*</span></label>
                        <input type="text" name="kode_asli" class="form-control" value="<?= old('kode_asli', 'BTKBR') ?>" required maxlength="8" placeholder="Masukkan kode produk">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Motif Batik <span class="text-danger">*</span></label>
                        <input type="text" name="motif" class="form-control" value="<?= old('motif') ?>" required placeholder="Masukkan motif batik">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi"><?= old('deskripsi') ?></textarea>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="harga" class="form-control" value="<?= old('harga') ?>" placeholder="Masukkan harga">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Produksi <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_produksi" class="form-control" value="<?= old('tanggal_produksi', date('Y-m-d')) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Pembuat <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pembuat" class="form-control" value="<?= old('nama_pembuat') ?>" required placeholder="Masukkan nama pembuat">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Produk <span class="text-danger">*</span></label>
                    <input type="file" name="foto_produk" class="form-control" required>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection()?>
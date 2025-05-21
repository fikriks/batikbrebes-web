<?= $this->extend('templates/admin') ?>

<?= $this->section('title') ?>
Edit Data Produk
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Edit Data Produk</h3>
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
            <form action="<?= base_url('admin/produk/update/' . $produk['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kode Produk <span class="text-danger"></span></label>
                        <input type="text" class="form-control" value="<?= $produk['kode_asli'] ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Motif Batik <span class="text-danger"></span></label>
                        <input type="text" name="motif" class="form-control" value="<?= old('motif', $produk['motif']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi <span class="text-danger"></span></label>
                    <textarea name="deskripsi" class="form-control" rows="3"><?= old('deskripsi', $produk['deskripsi']) ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Harga (Rp) <span class="text-danger"></span></label>
                        <input type="number" name="harga" class="form-control harga-rupiah" value="<?= old('harga', $produk['harga'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Produksi <span class="text-danger"></span></label>
                        <input type="date" name="tanggal_produksi" class="form-control" value="<?= old('tanggal_produksi', $produk['tanggal_produksi']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Pembuat <span class="text-danger"></span></label>
                        <input type="text" name="nama_pembuat" class="form-control" value="<?= old('nama_pembuat', $produk['nama_pembuat']) ?>" required>
                    </div>
                </div>

                <hr>

                <!-- Tampilkan foto produk jika ada -->
                <div class="mb-3">
                    <label class="form-label">Foto Produk Saat Ini</label>
                    <br>
                    <?php if ($produk['foto_produk_path']): ?>
                        <img src="<?= base_url($produk['foto_produk_path']) ?>" alt="Foto Produk" width="150">
                    <?php else: ?>
                        <span class="badge bg-warning">Tidak ada foto</span>
                    <?php endif; ?>
                </div>

                <!-- Input file untuk mengganti foto produk -->
                <div class="mb-3">
                    <label class="form-label">Ganti Foto Produk</label>
                    <input type="file" name="foto_produk" class="form-control">
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        // Fungsi untuk memformat Rupiah
        function formatRupiah(nilai) {
            nilai = nilai.toString().replace(/\D/g, '');
            return new Intl.NumberFormat('id-ID').format(nilai);
        }

        // Format nilai awal (old value) saat halaman dimuat
        let oldValue = $('.harga-rupiah').val();
        if (oldValue) {
            $('.harga-rupiah').val(formatRupiah(oldValue));
        }

        // Format Rupiah saat ketik
        $('.harga-rupiah').on('keyup', function() {
            let nilai = $(this).val();
            $(this).val(formatRupiah(nilai));
        });

        // Konversi ke angka sebelum submit form
        $('form').on('submit', function() {
            let harga = $('.harga-rupiah').val().replace(/\./g, '');
            $('.harga-rupiah').val(harga);
        });
    });
</script>
<?= $this->endSection() ?>
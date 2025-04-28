<?= $this->extend('templates/admin') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
    .card-statistics {
        background-color: #ffff;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-statistics .icon {
        background-color: #4a90e2;
        border-radius: 8%;
        padding: 20px 25px 20px 25px;
        color: white;
        font-size: 28px;
    }

    .card-statistics .details {
        flex-grow: 1;
        margin-left: 20px;
    }

    .card-statistics .details .title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    .card-statistics .details .value {
        font-size: 28px;
        color: #333;
    }

    /* Tambahan untuk gambar produk */
    .card-img-top {
        width: 100%;
        height: 220px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .card-img-top:hover {
        transform: scale(1.08);
        z-index: 2;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row mb-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Dashboard</h5>
                <p class="mb-0">Selamat datang di sistem keaslian produk batik tulis brebesan</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card-statistics">
            <div class="icon">
                <i class="ti ti-package"></i>
            </div>
            <div class="details">
                <div class="title">Total Produk</div>
                <div class="value"><?= count($produk) ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Card untuk 3 Produk Terbaru -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">3 Produk Terbaru</h5>
        <?php if (count($produk) > 0): ?>
            <div class="row">
                <?php $recentProducts = array_slice($produk, -3); ?>
                <?php foreach ($recentProducts as $item): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= base_url($item['foto_produk_path']) ?>" class="card-img-top" alt="<?= esc($item['motif']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($item['kode_asli']) ?> - <?= esc($item['motif']) ?></h5>
                                <p class="card-text">
                                    <?= strlen($item['deskripsi']) > 100 ? esc(substr($item['deskripsi'], 0, 100)) . '...' : esc($item['deskripsi']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="mb-0">Tidak ada produk yang terdaftar.</p>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
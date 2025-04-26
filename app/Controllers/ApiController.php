<?php
namespace App\Controllers;

use App\Models\ProdukModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\Des;

class ApiController extends ResourceController
{
    use ResponseTrait;
    
    protected $models;

    public function __construct()
    {
        $this->models = new ProdukModel();
    }

    /**
     * Endpoint untuk scan QR Code dari Android
     * Method: POST
     * URL: /api/scan
     * Body: { "kode_qr": "enkripsi_kode" }
     */
    public function scanQRCode()
    {
        $kodeQR = $this->request->getPost('kode_qr');

        if (empty($kodeQR)) {
            return $this->failValidationErrors([
                'kode_qr' => 'Kode QR harus diisi'
            ], 400);
        }

        // Validasi apakah kode QR adalah hexadecimal 16 karakter
        if (!preg_match('/^[a-fA-F0-9]{16}$/', $kodeQR)) {
            return $this->failValidationErrors([
                'kode_qr' => 'Kode QR tidak valid'
            ], 400);
        }

        try {
            $des = new Des();
            $key = "RUMAHBTK";
            $hexKey = bin2hex($key);
            $kodeDekripsiHex = $des->decrypt($kodeQR, $hexKey);
            $kodeDekripsi = hex2bin(strtolower($kodeDekripsiHex));

            $produk = $this->models->where('kode_asli', $kodeDekripsi)->first();

            if (!$produk) {
                return $this->failNotFound('Produk tidak ditemukan');
            }

            $response = [
                'status' => 200,
                'message' => 'Produk berhasil ditemukan',
                'data' => [
                    'id' => $produk['id'],
                    'kode_asli' => $produk['kode_asli'],
                    'motif' => $produk['motif'],
                    'deskripsi' => $produk['deskripsi'],
                    'harga' => $produk['harga'],
                    'tanggal_produksi' => $produk['tanggal_produksi'],
                    'nama_pembuat' => $produk['nama_pembuat'],
                    'qr_code_url' => base_url($produk['qr_code_path']),
                    'foto_produk_path' => base_url($produk['foto_produk_path'])
                ],
                'timestamp' => date('Y-m-d H:i:s')
            ];

            return $this->respond($response);

        } catch (\Exception $e) {
            return $this->failServerError('Terjadi kesalahan server: ' . $e->getMessage());
        }
    }
}
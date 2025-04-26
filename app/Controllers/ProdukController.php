<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Libraries\Des;

class ProdukController extends BaseController
{
    protected $models;

    public function __construct()
    {
        $this->models = new ProdukModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Produk',
            'produk' => $this->models->findAll()
        ];

        return view('admin/produk/index', $data);
    }

    public function tambah()
    {
        // Menampilkan form tambah data
        return view('admin/produk/tambah');
    }

    public function simpan()
    {
        // Validasi input
        $rules = [
            'kode_asli' => 'required|is_unique[produk.kode_asli]',
            'motif' => 'required',
            'tanggal_produksi' => 'required',
            'nama_pembuat' => 'required',
            'foto_produk' => 'uploaded[foto_produk]|max_size[foto_produk,2048]|is_image[foto_produk]'
        ];
    
        if (!$this->validate($rules)) {
            // Jika validasi gagal
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        $des = new Des();
        $plaintext = $this->request->getPost('kode_asli');
        $key = "RUMAHBTK";
        $hex = bin2hex($plaintext);
        $hexKey = bin2hex($key);
        $kodeEnkripsi = $des->encrypt($hex, $hexKey);
    
        // Handle upload foto
        $foto = $this->request->getFile('foto_produk');
        $fotoPath = 'uploads/foto-produk/';
        $fotoName = $foto->getRandomName();
        $foto->move(ROOTPATH . 'public/' . $fotoPath, $fotoName);
    
        // Generate QR Code
        $qrPath = $this->generateQRCode($kodeEnkripsi);
    
        // Data yang akan disimpan
        $data = [
            'kode_produk' => $kodeEnkripsi,
            'kode_asli' => $this->request->getPost('kode_asli'),
            'motif' => $this->request->getPost('motif'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'tanggal_produksi' => $this->request->getPost('tanggal_produksi'),
            'nama_pembuat' => $this->request->getPost('nama_pembuat'),
            'qr_code_path' => $qrPath,
            'foto_produk_path' => $fotoPath . $fotoName
        ];
    
        // Simpan ke database
        $this->models->save($data);
    
        // Redirect dengan pesan sukses
        return redirect()->to('admin/produk')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = $this->models->find($id);
        
        if (!$produk) {
            return redirect()->to('admin/produk')->with('error', 'Produk tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Produk',
            'produk' => $produk
        ];
        
        return view('admin/produk/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'motif' => 'required',
            'tanggal_produksi' => 'required',
            'nama_pembuat' => 'required',
            'foto_produk' => 'if_exist|max_size[foto_produk,2048]|is_image[foto_produk]'
        ];
    
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        $data = [
            'motif' => $this->request->getPost('motif'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'tanggal_produksi' => $this->request->getPost('tanggal_produksi'),
            'nama_pembuat' => $this->request->getPost('nama_pembuat')
        ];
    
        // Handle upload foto baru
        $foto = $this->request->getFile('foto_produk');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $produk = $this->models->find($id);
            if ($produk && $produk['foto_produk_path']) {
                $oldFotoPath = FCPATH . $produk['foto_produk_path'];
                if (file_exists($oldFotoPath)) {
                    unlink($oldFotoPath);
                }
            }
            $fotoPath = 'uploads/foto-produk/';
            $fotoName = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/' . $fotoPath, $fotoName);
            $data['foto_produk_path'] = $fotoPath . $fotoName;
        }
    
        $this->models->update($id, $data);
        return redirect()->to('admin/produk')->with('success', 'Produk berhasil diperbarui');
    }

    public function hapus($id)
    {
        $produk = $this->models->find($id);
        
        if ($produk && $produk['qr_code_path']) {
            $qrPath = WRITEPATH . str_replace('uploads/', 'uploads/', $produk['qr_code_path']);
            if (file_exists($qrPath)) {
                unlink($qrPath);
            }
        }

        $this->models->delete($id);
        return redirect()->to('admin/produk')->with('success', 'Produk berhasil dihapus');
    }

    private function generateQRCode($kode)
    {
        require_once APPPATH . 'Libraries/QRtools.php';
    
        $qrDir = FCPATH . 'uploads/qrcodes/'; // FCPATH = path ke folder public/
    
        if (!is_dir($qrDir)) {
            mkdir($qrDir, 0777, true);
        }
    
        $filename = 'qrcode_' . md5($kode) . '.png';
        $filepath = $qrDir . $filename;
    
        \QRcode::png($kode, $filepath, QR_ECLEVEL_L, 4);
    
        return 'uploads/qrcodes/' . $filename; // path relatif dari public/
    }
}

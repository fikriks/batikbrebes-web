<?php
namespace App\Controllers;

use App\Models\ProdukModel;
use CodeIgniter\Controller;

class AdminController extends Controller
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard Admin',
            'produk' => $this->produkModel->findAll()
        ];
        return view('admin/dashboard/index', $data);
    }     
}
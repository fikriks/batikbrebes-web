<?php
namespace App\Controllers;

use App\Models\AdminModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    protected $adminModel;
    
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        helper(['form', 'url']);
    }

    // Tampilkan halaman login
    public function login()
    {
        $data = [
            'title' => 'Login Admin',
            'validation' => \Config\Services::validation()
        ];
        
        return view('auth/login', $data);
    }

    // Proses login
    public function attemptLogin()
    {
        d($this->request->getPost()); // Lihat data yang dikirim form

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        // Debug pencarian user
        $admin = $this->adminModel->where('username', $username)->first();
        d($admin); // Lihat data user yang ditemukan
        
        if (!$admin) {
            d('User tidak ditemukan');
        } elseif (!password_verify($password, $admin['password'])) {
            d('Password tidak cocok');
            d('Input password: ' . $password);
            d('Hash di DB: ' . $admin['password']);
            d('Password verify: ' . password_verify($password, $admin['password']) ? 'true' : 'false');
        }
        $rules = [
            'username' => 'required|min_length[3]',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $admin = $this->adminModel->where('username', $username)->first();

        if (!$admin || !password_verify($password, $admin['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah');
        }

        // Update last login
        $this->adminModel->update($admin['id'], ['last_login' => date('Y-m-d H:i:s')]);

        // Set session
        session()->set([
            'admin_id' => $admin['id'],
            'admin_username' => $admin['username'],
            'logged_in' => true
        ]);

        return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, ' . $admin['username']);
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah logout');
    }
}
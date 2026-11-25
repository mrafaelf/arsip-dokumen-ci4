<?php
namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/archives');
        }
        return view('auth/login');
    }

    public function attempt()
    {
        $rules = ['email' => 'required|valid_email', 'password' => 'required'];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Email dan password wajib diisi dengan benar.');
        }

        $user = (new UserModel())->where('email', $this->request->getPost('email'))->first();

        if (! $user || ! password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        session()->regenerate();
        session()->set(['logged_in' => true, 'user_id' => $user['id'], 'user_name' => $user['name']]);

        return redirect()->to('/archives')->with('success', 'Selamat datang, ' . $user['name'] . '!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah logout.');
    }
}

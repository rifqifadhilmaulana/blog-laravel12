<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Tampilkan halaman login
    public function index(){
        return view('auth.login');
    }

    // Proses login (bisa username atau email)
   public function login_proses(Request $request)
{
    $request->validate([
        'login'    => 'required',
        'password' => 'required'
    ]);

    $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $data = [
        $loginType => $request->login,
        'password' => $request->password,
    ];

    if (Auth::attempt($data, $request->filled('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended(route('posts.index'));
    }

    return back()->withErrors([
        'login' => 'Username/Email atau password salah'
    ])->withInput();
}

    // Logout
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Tampilkan halaman register
    public function register(){
        return view('auth.register');
    }


    // Proses register
      public function register_proses(Request $request){
        $request->validate([
            'name'     => 'required|min:3|max:50',
            'username' => 'required|min:3|max:50|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ],
        // ... (Pesan validasi tetap sama)
        );

        // Simpan user baru
        $user = User::create([ // <-- Tangkap objek user yang baru dibuat
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => false, // Pastikan default user bukan admin
        ]);

        // LANGSUNG LOGIN DAN REDIRECT KE POSTS
        Auth::login($user); 
        $request->session()->regenerate();

        return redirect()->route('posts.index')->with('success', 'Registrasi berhasil! Selamat datang.');
    }
}
  
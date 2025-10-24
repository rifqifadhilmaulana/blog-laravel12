<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class ForgotPasswordController extends Controller
{
    // 1. Tampilkan form request email
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Proses pengiriman link reset password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $status = Password::sendResetLink($request->only('email'));

        return back()->with('status', __($status));
    }

    // 3. Tampilkan form untuk memasukkan password baru (setelah klik link email)
    public function showResetForm(string $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => request()->query('email')]);
    }

    // 4. Proses update password baru
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        // PENTING: Gunakan 'current_password' untuk memverifikasi password lama pengguna
        $validated = $request->validate([
            'current_password' => ['required', 'string', 'current_password'], 
            'password' => ['required', 'string', Password::defaults(), 'confirmed'], // Pastikan Password::defaults() dipanggil
        ], [
            // Pesan error kustom
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini tidak valid.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            // Catatan: Anda mungkin perlu menambahkan min:8 jika belum ada di Password::defaults()
        ]);

        // Perbarui kata sandi di database
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Arahkan kembali dengan pesan sukses
        return back()->with('success', 'Kata sandi berhasil diperbarui!');
    }
}
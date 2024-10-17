<?php

namespace App\Http\Controllers;

use App\Models\AuthModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    public function index(){

        return view('auth.login');
    }

    public function sigup(){
        return view('auth.register');
    }

    public function register(Request $request)
{

    try {
        // Insert data user
        $user = AuthModel::create([
            'Name' => $request->name,
            'Email' => $request->email,
            'Password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);

    } catch (QueryException $e) {
        // Tangani jika terjadi kesalahan query
        return response()->json([
            'message' => 'Failed to register user',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    // Cek kredensial pengguna
    $credentials = $request->only('email', 'password');

    // Auth::attempt akan otomatis mengecek hash bcrypt di database
    if (Auth::attempt($credentials)) {
        // Regenerasi sesi setelah berhasil login
        $request->session()->regenerate();

        // Redirect ke dashboard
        return redirect()->intended('/dashboard')->with('success', 'Login berhasil');
    }

    // Jika login gagal
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
}
}

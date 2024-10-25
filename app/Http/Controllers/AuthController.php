<?php

namespace App\Http\Controllers;

use App\Models\AuthModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

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
            'Active'   => 0
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
        try {
            // Validasi input
            
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            // Cek kredensial pengguna
            //$credentials = $request->only('email', 'password');
            // dd($credentials);
            $user = AuthModel::where('email', $request->email)->first();
            if(Hash::check($request->password,$user->Password) && $user->Email == $request->email)
            {
                // Jika login berhasil, simpan data ke session
                $request->session()->regenerate(); // Regenerasi session ID untuk keamanan

                // Simpan informasi pengguna ke dalam session
                Session::put('UserID', $user->UserID);
                Session::put('Email', $user->Email);
                Session::put('HakAksesID', $user->HakAksesID); // Simpan hak akses jika diperlukan


                return response()->json([
                    'status' => true,
                    'message' => 'Login Successfully',
                ],200);
            } else 
            {
                // Jika login gagal
                return response()->json([
                    'status' => false,
                    'message' => 'Password or Email is Wrong',
                ],200);
            }

            // if (!$user) {
            //     // Jika email tidak ditemukan
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => 'Email tidak ditemukan.',
            //     ], 404);
            // }

            // // Jika email ditemukan, cek password dengan Auth::attempt
            // if (!Auth::attempt($request->only('email', 'password'))) {
            //     // Jika password salah
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => 'Password salah.',
            //     ], 401);
            // }
            // Auth::attempt akan otomatis mengecek hash bcrypt di database
            // if (Auth::attempt($credentials)) {
            //     // Regenerasi sesi setelah berhasil login
            //     // $request->session()->regenerate();

            //     // Redirect ke dashboard
            //     return response()->json([
            //         'status' => true,
            //         'message' => 'Login berhasil',
            //     ]);
            // }

            
        } catch (\Exception $e) {
            // Menangkap semua error yang mungkin terjadi
            // return back()->withErrors([
            //     'error' => 'Terjadi kesalahan pada server: ' . $e->getMessage(),
            // ])->withInput();
            return json_encode($e);
        }
    }

}

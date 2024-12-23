<?php

namespace App\Http\Controllers;

use App\Models\AuthModel;
use App\Models\MainModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $main;

    // Model di-inject melalui constructor
    public function __construct(MainModel $main)
    {
        $this->main = $main;
    }

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
        $ReferralCode = $this->main::GenerateReferralCode();
        $user = AuthModel::create([
            'Name' => $request->name,
            'Email' => $request->email,
            'Password' => Hash::make($request->password),
            'ReferralCode' => $ReferralCode,
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
            $user = AuthModel::where('A.email', $request->email)
            ->from('user as A')
            ->leftJoin('reseller as B', 'A.UserID', '=', 'B.UserID') // Melakukan LEFT JOIN ke tabel profiles
            ->select(
                'A.UserID', 
                'A.Password',
                'A.Email',
                'A.Name',
                'A.HakAksesID',
                'B.ResellerID',
                ) 
            ->first();
            if(Hash::check($request->password,$user->Password) && $user->Email == $request->email)
            {
                // Jika login berhasil, simpan data ke session
                $request->session()->regenerate(); // Regenerasi session ID untuk keamanan

                // Simpan informasi pengguna ke dalam session
                Session::put('UserID', $user->UserID);
                Session::put('ResellerID', $user->ResellerID);
                Session::put('Name',$user->Name);
                Session::put('Email', $user->Email);
                Session::put('HakAksesID', $user->HakAksesID); // Simpan hak akses jika diperlukan

                if($user->ResellerID):
                    $redirect = 'paket';
                else:
                    $redirect = 'dashboard';
                endif;
                $response = array(
                    'status' => true,
                    'redirect' => $redirect
                );

               echo json_encode($response);
            } else 
            {
                // Jika login gagal
                return response()->json([
                    'status' => false,
                    'message' => 'Password or Email is Wrong',
                ],200);
            }
           
        } catch (\Exception $e) {
            // Menangkap semua error yang mungkin terjadi
            // return back()->withErrors([
            //     'error' => 'Terjadi kesalahan pada server: ' . $e->getMessage(),
            // ])->withInput();
            return json_encode($e);
        }
    }

}

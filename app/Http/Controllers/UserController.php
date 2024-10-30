<?php

namespace App\Http\Controllers;

use App\Models\MainModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $main;

    // Model di-inject melalui constructor
    public function __construct(MainModel $main)
    {
        $this->main = $main;
    }


    public function index(){

        $list_data = UserModel::getalluser();
        $list_hakakses = $this->main::GetHakAkses();

        return view('backend.master.users.index',compact('list_data','list_hakakses'));
    }


    public function edit(Request $request, $id)
    {
        $data = UserModel::getById($id);

        // Periksa apakah produk ditemukan
        if ($data) {
            return response()->json([
                'message' => 'Product found',
                'product' => $data
            ], 200);
        } else {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        
    }

    public function save(Request $request){
        if ($request->userid == '') {
            $ReferralCode = $this->main::GenerateReferralCode();
            $request->merge(['ReferralCode' => $ReferralCode]);
            $ResellerID = UserModel::insert($request->all());
            return redirect()->route('user.index')
            ->with('success', 'User created successfully.');
        } else {
            // Jika productId ada, jalankan update
            $result = UserModel::updateUser($request->userid, $request->all());
            return redirect()->route('user.index')
            ->with('success', 'User update successfully.');
        }
    }

    public function delete($id)
    {
        $data = UserModel::deleteData($id);
        if ($data) {
            return redirect()->back()->with('success', 'Data deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete Data.');
        }
    }
}

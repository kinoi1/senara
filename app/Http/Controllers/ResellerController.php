<?php

namespace App\Http\Controllers;

use App\Models\ResellerModel;
use Illuminate\Http\Request;

class ResellerController extends Controller
{
    public function index(){

        $list_data = ResellerModel::getallreseller();
        return view('backend.master.reseller.index',compact('list_data'));
    }


    public function edit(Request $request, $id)
    {
        $data = ResellerModel::getById($id);

        // Periksa apakah produk ditemukan
        if ($data) {
            return response()->json([
                'message' => 'Product found',
                'reseller' => $data
            ], 200);
        } else {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        
    }

    public function save(Request $request){
        if ($request->hasFile('gambar')) {
            // Simpan file gambar dan ambil path-nya
            $imagePath = $request->file('gambar')->store('gambar', 'public'); // Folder "product_images" di storage/public
            $request->merge(['imagepath' => $imagePath]);
        } else {
            $imagePath = null; // Jika tidak ada gambar, set null
            $request->merge(['imagepath' => $imagePath]);
        }

        if ($request->productid == '') {
            $ResellerID = ResellerModel::insert($request->all());
            return redirect()->route('reseller.index')
            ->with('success', 'Product created successfully.');
        } else {
            // Jika productId ada, jalankan update
            $result = ResellerModel::updateProduct($request->resellerid, $request->all());
            return redirect()->route('reseller.index')
            ->with('success', 'Product update successfully.');
        }
    }

    public function delete($id)
    {
        $data = ResellerModel::deleteData($id);
        if ($data) {
            return redirect()->back()->with('success', 'Data deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete Data.');
        }
    }
}

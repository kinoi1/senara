<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){

        $list_data = CategoryModel::getallcategory();
        return view('backend.master.category.index',compact('list_data'));
    }


    public function edit(Request $request, $id)
    {
        $data = CategoryModel::getById($id);

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
        if ($request->productid == '') {
            $ResellerID = CategoryModel::insert($request->all());
            return redirect()->route('product.index')
            ->with('success', 'Product created successfully.');
        } else {
            // Jika productId ada, jalankan update
            $result = CategoryModel::updateProduct($request->productid, $request->all());
            return redirect()->route('product.index')
            ->with('success', 'Product update successfully.');
        }
    }

    public function delete($id)
    {
        $data = CategoryModel::deleteData($id);
        if ($data) {
            return redirect()->back()->with('success', 'Data deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete Data.');
        }
    }
}

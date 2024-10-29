<?php

namespace App\Http\Controllers;

use App\Models\MainModel;
use Illuminate\Http\Request;
use App\Models\CategoryModel;

class CategoryController extends Controller
{
    protected $main;

    // Model di-inject melalui constructor
    public function __construct(MainModel $main)
    {
        $this->main = $main;
    }
    
    public function index(){

        // $list_type = $this->main::GetCategoryType();
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
                'category' => $data
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

        if(!$request->percent){
            $request->merge(['percent' => null]);
        }
        if(!$request->percent){
            $request->merge(['duration' => null]);
        }
        if(!$request->percent){
            $request->merge(['date' => null]);
        }

        if ($request->categoryid == '') {
            $CategoryID = CategoryModel::insert($request->all());
            return redirect()->route('category.index')
            ->with('success', 'Product created successfully.');
        } else {
            // Jika productId ada, jalankan update
            $result = CategoryModel::updateCategory($request->categoryid, $request->all());
            return redirect()->route('category.index')
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

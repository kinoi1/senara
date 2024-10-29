<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductModel extends Model
{
    public static function getallproduct(){
        return DB::table('product as A')
             ->select('A.ProductID','A.CategoryID','A.Name','B.Name as CategoryName', 'A.Price','A.Qty','A.Image')
             ->leftJoin('Category as B','A.CategoryID','=','B.CategoryID')
             ->get();
     }
 
     public static function insert($data)
     {
         $insert_id = DB::table('product')->insertGetId([
                 'CategoryID' => $data['categoryid'],
                 'Name' => $data['nama'],
                 'Price' => $data['price'],
                 'Qty'   => $data['qty'],
                 'Image' => $data['imagepath']
             ]);
  
         return $insert_id;
     }

     public static function updateProduct($productid, $data)
     {
        return DB::table('product')
             ->where('ProductID', $productid)
             ->update([
                 'CategoryID' => $data['categoryid'],
                 'Name' => $data['nama'],
                 'Price' => $data['price'],
                 'Qty'   => $data['qty'],
                 'Image' => $data['imagepath']
             ]);
     }
 
     public static function getById($id)
     {
         return DB::table('product')
         ->select('ProductID','CategoryID','Name', 'Price','Qty','Image')
         ->where('ProductID', $id)->first();
     }
 
     public static function deleteData($id)
     {
         return DB::table('product')->where('ProductID', $id)->delete();
     }
}

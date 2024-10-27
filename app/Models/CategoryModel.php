<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryModel extends Model
{
    public static function getallcategory(){
        return DB::table('category')
             ->select('CategoryID','Name', 'Active','Image')
             ->get();
     }
 
     public static function insert($data)
     {
         $insert_id = DB::table('category')->insertGetId([
                 'Name' => $data['name'],
                 'Image' => $data['imagepath'],
                 'Active'   => 1,
                 'DateAdd' => date('Y-m-d H:i:s'),
             ]);
  
         return $insert_id;
     }

     public static function updateCategory($categoryid, $data)
     {
        return DB::table('category')
             ->where('CategoryID', $categoryid)
             ->update([
                 'Name' => $data['name'],
                 'Image' => $data['imagepath'],
                 'Active'   => 1,
                 'UpdateAt' => date('Y-m-d H:i:s')
             ]);
     }
 
     public static function getById($id)
     {
         return DB::table('category')
         ->select('CategoryID','Name','Image')
         ->where('CategoryID', $id)->first();
     }
 
     public static function deleteData($id)
     {
         return DB::table('category')->where('CategoryID', $id)->delete();
     }
}

<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserModel extends Model
{
    public static function getalluser(){
        return DB::table('user')
             ->select('UserID','Name', 'Price','Qty','Image')
             ->get();
     }
 
     public static function insert($data)
     {
         $insert_id = DB::table('user')->insertGetId([
                 'Name' => $data['nama'],
                 'Price' => $data['price'],
                 'Qty'   => $data['qty'],
                 'Image' => $data['imagepath']
             ]);
  
         return $insert_id;
     }

     public static function updateUser($UserID, $data)
     {
        return DB::table('user')
             ->where('UserID', $UserID)
             ->update([
                 'Name' => $data['nama'],
                 'Email' => $data['price'],
                 'Qty'   => $data['qty'],
                 'Image' => $data['imagepath']
             ]);
     }
 
     public static function getById($id)
     {
         return DB::table('user')
         ->select('UserID','Name', 'Price','Qty','Image')
         ->where('UserID', $id)->first();
     }
 
     public static function deleteData($id)
     {
         return DB::table('user')->where('UserID', $id)->delete();
     }
}

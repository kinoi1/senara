<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserModel extends Model
{
    public static function getalluser(){
        return DB::table('user as A')
             ->select('A.UserID','A.Name', 'A.Email','A.Image','B.Name as HakAkses','A.ReferralCode')
             ->leftJoin('hakakses as B', 'A.HakAksesID', '=', 'B.HakAksesID') 
             ->get();
     }
 
     public static function insert($request)
     {
         $insert_id = DB::table('user')->insertGetId([
                'Name'        => $request['name'],
                'Email'       => $request['email'],
                'Password'    => Hash::make($request['password']),
                'ReferralCode'=> $request['ReferralCode'],
                'Active'      => 0,
                'HakAksesID'  => $request['hakaksesid']
             ]);
  
         return $insert_id;
     }

     public static function updateUser($UserID, $data)
     {
        return DB::table('user')
             ->where('UserID', $UserID)
             ->update([
                'Name'       => $data->name,
                'Email'      => $data->email,
                'Active'     => 0,
                'HakAksesID' => $data->hakaksesid
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

    //  public static function cekReferralCode($referralCode){
    //     return DB::table('user')->where('ReferralCode', $referralCode)->exists();
    //  }

}

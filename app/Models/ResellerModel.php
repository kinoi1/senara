<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResellerModel extends Model
{
    public static function getallreseller(){
       return DB::table('reseller')
            ->select('ResellerID','Name', 'Refferal')
            ->get();
    }

    public static function insert($data)
    {
        DB::table('reseller')->insert([
                'Name' => $data['nama'],
                'refferal' => $data['refferal'],
                'ImagePath' => $data['imagepath']
            ]);
 
        return true;
    }

    public static function getById($id)
    {
        return DB::table('reseller')
        ->select('ResellerID','Name', 'Refferal')
        ->where('ResellerID', $id)->first();
    }

    
    public static function updateProduct($resellerid, $data)
    {
       return DB::table('reseller')
            ->where('ResellerID', $resellerid)
            ->update([
                'Name' => $data['nama'],
                'Refferal' => $data['refferal'],
                'ImagePath' => $data['imagepath']
            ]);
    }

    public static function deleteData($id)
    {
        return DB::table('reseller')->where('ResellerID', $id)->delete();
    }
}

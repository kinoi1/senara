<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainModel extends Model
{
    use HasFactory;

    public static function GetMenuID($id){
        return DB::table('hakakses')
                    ->select('MenuID')
                    ->where('HakAksesID', $id)
                    ->get();
    }

    public static function GetMenu($id){
        return DB::table('menu')
                    ->select('MenuID','Name','Icon')
                    ->whereIn('MenuID', $id)
                    ->get();
    }
}

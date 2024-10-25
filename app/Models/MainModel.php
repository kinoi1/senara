<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainModel extends Model
{
    use HasFactory;

    const table_hakakses = 'hakakses';

    public static function GetMenuID($id)
    {
        return DB::table(self::table_hakakses)
                    ->select('MenuID')
                    ->where('HakAksesID', $id)
                    ->get();
    }

    public static function GetMenu($id)
    {
        return DB::table('menu')
                    ->select('MenuID','Name','Icon','Link')
                    ->whereIn('MenuID', $id)
                    ->get();
    }

    public static function GetHakAkses()
    {
        return DB::table(self::table_hakakses)
        ->select('HakAksesID','Name')
        ->get();
    }
}

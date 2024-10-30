<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainModel extends Model
{
    use HasFactory;

    const table_hakakses = 'hakakses';
    // const table_categorytype = 'categorytype';
    const table_menu = 'menu';
    const table_category = 'category';
    const table_user = 'user';

    public static function GetMenuID($id)
    {
        return DB::table(self::table_hakakses)
                    ->select('MenuID')
                    ->where('HakAksesID', $id)
                    ->get();
    }

    public static function GetMenu($id)
    {
        return DB::table(self::table_menu)
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

    // public static function GetCategoryType()
    // {
    //     return DB::table(self::table_categorytype)
    //     ->select('CategoryTypeID','Name')
    //     ->get();
    // }

    public static function GetCategory()
    {
        return DB::table(self::table_category)
            ->select('CategoryID','Name')
            ->get();
    }

    public static function GenerateReferralCode() {
        $length = 6;
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        
        do {
            $referralCode = '';
            for ($i = 0; $i < $length; $i++) {
                $referralCode .= $characters[rand(0, $charactersLength - 1)];
            }
    
            // Cek apakah kode sudah ada di tabel user
            $codeExists = DB::table('user')->where('ReferralCode', $referralCode)->exists();
    
        } while ($codeExists);
    
        return $referralCode;
    }
}

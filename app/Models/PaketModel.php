<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaketModel extends Model
{
    use HasFactory;

    
    public static function GetProduct(){
        return DB::table('product as A')
             ->select('A.ProductID','A.CategoryID','A.Name','A.Price','A.Qty','A.Image')
             ->where('A.CategoryID','=',3)
             ->get();
     }
}

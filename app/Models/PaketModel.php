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
     public static function insert($data)
     {
         $insert_id = DB::table('transactioncart')->insertGetId([
                 'ProductID' => $data['productid'],
                 'ResellerID' => $data['resellerid'],
                 'Qty'   => $data['qty'],
             ]);
  
         return $insert_id;
     }

     public static function GetCountCart(){
        return DB::table('transactioncart')
                ->where('ResellerID','=',Session('ResellerID'))
                ->count();
     }
     public static function GetListCartByID(){
        return DB::table('transactioncart as A')
             ->select('A.ProductID','A.Qty','B.Name','B.Price',
                DB::raw("CONCAT('" . asset('storage/') . "/', B.Image) as Image"))
             ->leftJoin('product as B','A.ProductID','=','B.ProductID')
             ->where('A.ResellerID','=',Session('ResellerID'))
             ->get();
     }
}

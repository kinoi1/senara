<?php

namespace App\Http\Controllers;

use App\Models\PaketModel;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    //
    public function index(){
        $list_best = PaketModel::GetProduct();
        $count_cart = PaketModel::GetCountCart();
        return view('frontend.layouts.index',compact('list_best','count_cart'));
    }

    public function addToCart(Request $request){
        $request->merge(['resellerid' => Session('ResellerID')]);
        $CartID = PaketModel::insert($request->all());

        echo JSON_ENCODE('berhasil');

    }
}

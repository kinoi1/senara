<?php

namespace App\Http\Controllers;

use App\Models\PaketModel;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    //
    public function index(){
        $list_best = PaketModel::GetProduct();

        return view('frontend.layouts.index',compact('list_best'));
    }
}

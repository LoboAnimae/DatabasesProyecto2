<?php

namespace App\Http\Controllers;

use App\shoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class MongoController extends Controller
{
    //
    public function index(){
        $logs = shoppingCart::all();
        return $logs;

    }
}

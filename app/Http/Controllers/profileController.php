<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class profileController extends Controller
{

    public function profile($section = 'beginningSection',$name = 'guest', $code1 = 1){
        return view('profile_information', compact('section','name', 'code1'));
    }
    public function funStats($section = 'beginningSection',$name = 'guest', $code1 = 1){
        return view('choose_statistics', compact('section', 'name', 'code1'));
    }



//    public function redirect($section = 'main', $name = 'Guest', $code1 = 10) {
//        if($section == 'beginningSection'){
//
//            return view('profile_information', compact('section', 'name', 'code1'));
//        }
//        elseif ($section = 'main'){
//
//        }
//        else {
//            return view('PageNotFound');
//        }
//        return view('profile_information', compact('section', 'name', 'code1'));
//    }
}

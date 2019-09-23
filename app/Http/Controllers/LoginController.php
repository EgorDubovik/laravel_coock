<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function loginPhone(Request $request){
    	return view("login_phone");
    }

    public function getCode(Request $request){
    	if($request->phone){
    		return redirect()->route("code");
    	} else {
    		return redirect()->route("phone");
    	}	
    }

    public function loginCode(Request $request){
    	return view("login_code");	
    }

    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;

class AddressController extends Controller
{
 	public function setAddress(Request $request){
 		$user = $request->user();
 		if($user->address()===null){
 			return response()->json("new");
 		} else {
 			return response()->json("isset");
 		}
 	}   
}

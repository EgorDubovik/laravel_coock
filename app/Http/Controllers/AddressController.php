<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;

class AddressController extends Controller
{
 	public function setAddress(Request $request){
 		$user = $request->user();
 		$address = $user->address()->first();
 		try {
 			if(!$address){
	 			$user->address()->firstOrCreate($request->toArray());
	 		} else {
	 			$address->update($request->toArray());
	 		}
 		} catch (Exception $e) {
			return response()->json(["status"=>"false","message"=>$e]); 			
 		}
 		

 		return response()->json(["status"=>"true"]);
 	}   
}

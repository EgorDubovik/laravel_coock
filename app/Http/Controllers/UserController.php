<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    private $client;

    function __construct(){
    	$this->client = DB::table("oauth_clients")->where('id',2)->first();
    }

    public function getCode(Request $request){
    	$phone = $request->phone;
    	$user = User::firstOrNew(["name"=>$phone]);
    	$code = mt_rand(1000,9999);
    	$user->password = bcrypt($code);
    	$user->save();
    	return response()->json(["code"=>$code]);
    }

    public function getToken(Request $request){
    	$request->request->add([
			'username' => $request->phone,
			'password' => $request->code,
			'grant_type' => 'password',
			'client_id' => $this->client->id,
			'client_secret' => $this->client->secret,
			'scope' => '*'
		]);

		$proxy = Request::create(
			'oauth/token',
			'POST'
		);


		return Route::dispatch($proxy);
    }

    public function getUser(Request $request){
        $user = $request->user();
        $user->load("address");
        return response()->json($user);
    }

    public function setTypeCustomer(Request $request){
        $evalieble_status = [1,2];
        $is_coocked = $request->is_coocked;
        if(in_array($is_coocked,$evalieble_status)){
            $request->user()->is_coocked = $is_coocked;
            $request->user()->save();
            return response()->json(["status"=>"true"]);
        } else {
            return response()->json(["status"=>"false","messange"=>"invalid status"]);
        }
    }
}

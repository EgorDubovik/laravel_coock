<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $client;

    function __construct(){
    	$this->client = DB::table("oauth_clients")->where('id',2)->first();
    }

    public function getCode(Request $request){
        if($request->phone){
        	$phone = $request->phone;
        	$user = User::firstOrNew(["name"=>$phone]);
        	$code = mt_rand(1000,9999);
        	$user->password = bcrypt($code);
        	$user->save();
        	return response()->json(["status"=>true,"code"=>$code]);
        } else {
            return response()->json(["status"=>false,"message"=>"need phone field"]);
        }
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
            return response()->json(["status"=>"false","message"=>"invalid status"]);
        }
    }

    public function setAvatar(Request $request){

        $fieldName = "avatar";

        $limitFileWidthAndHeight = 500;
        $return = [
            "status"=>false,
            "code"=>0,
        ];


        $validate = Validator::make($request->all(),[
            $fieldName => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        
        if($validate->fails()){
            $return['code']=2;
            $return['message'] = $validate->errors();
            return response()->json($return);
        }

        $file = $request->file($fieldName);

        $fileInfo['name'] = $file->getClientOriginalName();
        $fileInfo['size'] = $file->getSize();
        $fileInfo['ext'] = $file->getClientOriginalExtension();
        // Get image size (width and heught)
        $imagedetails = getimagesize($_FILES[$fieldName]['tmp_name']);
        $fileInfo['width'] = $imagedetails[0];
        $fileInfo['height'] = $imagedetails[1];

        if($fileInfo['width']<$limitFileWidthAndHeight || $fileInfo['height']<$limitFileWidthAndHeight){
            $return['code'] = 1; // Error width or height size;
        } else {
            $newname = uniqid('img_').".jpg";
            $file->move("images",$newname);
            $request->user()->avatar = $newname;
            $request->user()->save();
            $return['status'] = true;
        }
        return response()->json($return);
    }

    public function addMenu(Request $request){
        $title = ($request->title) ? $request->title : null;
        $description = ($request->description) ? $request->description : null;
        $weight = ($request->weight) ? $request->weight : null;
        $valume = ($request->valume) ? $request->valume : null;
        $price = ($request->price) ? $request->price : null;

        $request->user()->menu()->create(
            [   
                "title"=>$title,
                "description"=>$description,
                "weight" => $weight,
                "valume" => $valume,
                "price" => $price
            ]
        );

        return response()->json(["status"=>true]);
    }
}

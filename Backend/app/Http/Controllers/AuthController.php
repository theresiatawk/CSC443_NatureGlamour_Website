<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    function register(Request $request){
        $validate = Validator::make($request->all(), [
            'username' => 'required|string|alpha_dash|max:255',
            'email' => 'required|string|regex:/(.+)@(.+)\.(.+)/i|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validate->fails()){
            return response()->json([
                "status" => "failed",
                "results" => []
            ], 400);
        }
        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if($user->save()){
            return response()->json([
                "status" => "success",
                "results" => $user
            ], 200);
        }else{
            return response()->json([
                "status" => "failure",
                "results" => []
            ], 400);
        }
    }
}

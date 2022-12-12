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
        $validate_username = Validator::make($request->all(), [
            'username' => 'required|string|alpha_dash|max:255',
        ]);
        if($validate_username->fails()){
            return response()->json([
                "status" => "failed",
                "results" => "Useername must contain letters, numbers, dashes and underscores and NOT space"
            ], 400);
        }
        $validate_email_exist = Validator::make($request->all(), [
            'email' => 'required|string|regex:/(.+)@(.+)\.(.+)/i|max:255|unique:users',
        ]);
        if($validate_email_exist->fails()){
            return response()->json([
                "status" => "failed",
                "results" => "This email is already registred"
            ], 400);
        }
        $validate_email = Validator::make($request->all(), [
            'email' => 'required|string|regex:/(.+)@(.+)\.(.+)/i|max:255|unique:users',
        ]);
        if($validate_email->fails()){
            return response()->json([
                "status" => "failed",
                "results" => "Invalid email format"
            ], 400);
        }
        $validate_password = Validator::make($request->all(), [
            'password' => 'required|string|min:8', 
        ]);
        if($validate_password->fails()){
            return response()->json([
                "status" => "failed",
                "results" => "Password must contain at least 8 characters"
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

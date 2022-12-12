<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        if($validate->fails()){
            return response()->json([
                "status" => "error",
                "results" => "Some fields are empty"
            ], 400);
        }
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials',
            ], 401);
        }
        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
    }

    function register(Request $request){
        $validate_username = Validator::make($request->all(), [
            'username' => 'required|string|alpha_dash|max:255',
        ]);
        if($validate_username->fails()){
            return response()->json([
                "status" => "error",
                "results" => "Username must contain letters, numbers, dashes and underscores and NOT space"
            ], 400);
        }
        $validate_email_exist = Validator::make($request->all(), [
            'email' => 'required|string|regex:/(.+)@(.+)\.(.+)/i|max:255|unique:users',
        ]);
        if($validate_email_exist->fails()){
            return response()->json([
                "status" => "error",
                "results" => "This email is already registred"
            ], 400);
        }
        $validate_email = Validator::make($request->all(), [
            'email' => 'required|string|regex:/(.+)@(.+)\.(.+)/i|max:255|unique:users',
        ]);
        if($validate_email->fails()){
            return response()->json([
                "status" => "error",
                "results" => "Invalid email format"
            ], 400);
        }
        $validate_password = Validator::make($request->all(), [
            'password' => 'required|string|min:8', 
        ]);
        if($validate_password->fails()){
            return response()->json([
                "status" => "error",
                "results" => "Password must contain at least 8 characters"
            ], 400);
        }
        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if($user->save()){
            $token = Auth::login($user);
            return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
        }else{
            return response()->json([
                "status" => "error",
                "results" => []
            ], 400);
        }
    }
}

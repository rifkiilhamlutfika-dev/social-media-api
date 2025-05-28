<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => "required|string|max:255",
            'email' => "required|string|email|max:255",
            'password' => "required|string|min:6"
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors()
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'data' => compact('user', 'token')
        ], 201);
    }

    public function login(Request $request)
    {
        $credential = $request->only('email', 'password');

        $token = JWTAuth::attempt($credential);

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'invalid credentials'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'messages' => 'login has been successful!',
            'data' => compact('token')
        ]);
    }
}

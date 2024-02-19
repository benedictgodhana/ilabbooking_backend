<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate login credentials
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            $role = $user->roles->first()->name; // Assuming you have a relationship to roles

            return response()->json([
                'token' => $token,
                'role' => $role,
                'user'=>$user,
            ]);
        } else {
            // Authentication failed
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }



    public function register(Request $request)
    {
        // Implement user registration logic
    }

    public function logout(Request $request)
    {
        // Revoke the current user's token
        $request->user()->tokens()->delete();

        // Return a success response
        return response()->json(['message' => 'Successfully logged out']);
    }

    // Add other authentication-related methods as needed
}

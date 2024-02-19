<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser()
    {
        // Assuming you want to fetch the currently authenticated user
        $user = auth()->user();

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function permissions(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Check if the user is authenticated
        if ($user) {
            // Get the user's permissions
            $permissions = $user->permissions()->pluck('name')->toArray();

            // Return the permissions as JSON response
            return response()->json(['permissions' => $permissions]);
        } else {
            // If user is not authenticated, return 401 Unauthorized
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}

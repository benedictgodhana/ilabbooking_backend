<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class UserController extends Controller
{
    public function getUser()
    {
        $users = User::with('roles:name')->get(['id', 'name', 'email']);
        return response()->json(['users' => $users]);
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

    public function store(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8', // Add validation rules for password
        'role' => 'required|string|max:255|exists:roles,name', // Validate that the role exists in the roles table
    ]);

    // Create a new user instance
    $user = new User();
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->password = Hash::make($validatedData['password']); // Hash the password before saving
    $user->save();

    // Assign the role to the user using Spatie
    $role = Role::where('name', $validatedData['role'])->firstOrFail(); // Retrieve the role by name
    $user->assignRole($role); // Assign the role to the user

    // Optionally, you can return a response with the newly created user data
    return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
}
public function update(Request $request, $id)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'string|max:255',
        'email' => 'string|email|max:255|unique:users,email,'.$id, // Allow the email to be the same as the current user's email
        'password' => 'nullable|string|min:8', // Allow the password to be nullable
        'role' => 'string|max:255|exists:roles,name', // Validate that the role exists in the roles table
    ]);

    // Find the user by ID
    $user = User::findOrFail($id);

    // Update user fields if provided in the request
    if (isset($validatedData['name'])) {
        $user->name = $validatedData['name'];
    }
    if (isset($validatedData['email'])) {
        $user->email = $validatedData['email'];
    }
    if (isset($validatedData['password'])) {
        $user->password = Hash::make($validatedData['password']); // Hash the new password
    }

    // Update the user's role if provided in the request
    if (isset($validatedData['role'])) {
        $role = Role::where('name', $validatedData['role'])->firstOrFail();
        $user->syncRoles([$role->name]); // Sync the user's roles
    }

    // Save the updated user
    $user->save();

    // Optionally, you can return a response with the updated user data
    return response()->json(['message' => 'User updated successfully', 'user' => $user]);
}

        public function destroy($id)
        {
            // Find the user by ID
            $user = User::findOrFail($id);

            // Delete the user
            $user->delete();

            // Optionally, you can return a response
            return response()->json(['message' => 'User deleted successfully']);
        }

}

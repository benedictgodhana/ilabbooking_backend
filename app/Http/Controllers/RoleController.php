<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function getRoles()
    {
        $roles = Role::all();

        return response()->json(['roles' => $roles]);
    }
}

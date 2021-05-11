<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::where('slug', '!=', 'admin')->latest()->get();
//        $roles = Role::all()->toArray();
//        return array_reverse($roles);
        return response()->json(["data" => $roles]);
    }

    public function all()
    {
        $roles = Role::all()->toArray();
        return array_reverse($roles);
    }
}

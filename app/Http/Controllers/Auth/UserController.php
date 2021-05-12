<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
//        if ($request->user()->can('edit-users')) {
//            return response()->json(User::all());
//        }

        return UserResource::collection(User::all()->where('id', '!=', \Auth::user()->id));

//        $users = \DB::table('users_roles')
//            ->join('users', 'users.id', '=', 'users_roles.user_id')
//            ->join('roles', 'roles.id', '=', 'users_roles.role_id')
//            ->get();
//        return response()->json(["data" => $users]);
    }

    /**
     * Get authenticated user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return UserResource
     */
    public function current(Request $request)
    {
//        return response()->json($request->user());
        return new UserResource($request->user());
    }
}

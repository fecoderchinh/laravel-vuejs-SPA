<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request)
//    {
//        $this->validate($request, [
//            'password' => 'required|confirmed|min:6',
//        ]);
//
//        $request->user()->update([
//            'password' => bcrypt($request->password),
//        ]);
//    }


    public function update(Request $request)
    {
        $rules = [
            'password' => 'required',
            'new_password' => 'required|different:password',
            'confirm_password' => 'required|same:new_password'
        ];

        $user = $request->user();

        $this->validate($request, $rules);

        if (\Hash::check($request->password, $user->password)) {
            $user->password = bcrypt($request->input('new_password'));
            $user->saveOrFail();
        } else {
            return response([
                'status' => false,
                'message' => 'Old password is incorrect.'
            ], 400);
        }

//        return response()->json(compact('user'));
//        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Hash;

class UpdateUserController extends Controller
{
    public function update(Request $request){
        $user = Auth::user();
        /*$validator = $this->validate(request(), [
            //'update_email' => 'unique:users,email,'.$user->id,
            'update_email' => 'required|email|unique:users,email,'.$user->id,
            'update_password' => 'required|confirmed|min:6'
        ]);*/

        $validator = Validator::make($request::all(), [
            //'update_email' => 'unique:users,email,'.$user->id,
            'update_email' => 'required|email|unique:users,email,'.$user->id,
            'update_password' => 'required|confirmed|min:6'
        ]);

        //create post
        if($validator->fails()){
            return redirect('/dashboard#settings')->withErrors($validator);
        }

        $user->mobile_num = $request->input('update_mobile');
        $user->email = $request->input('update_email');
        if(!empty($request->input('update_password'))){
            if($request->input('update_password')==$request->input('update_password_confirmation')){
                $user->password = Hash::make($request->input('update_password'));
            }
        }
        //$user->body = $request->input('body');
        $user->save();

        return redirect('/dashboard#settings');
    }
}

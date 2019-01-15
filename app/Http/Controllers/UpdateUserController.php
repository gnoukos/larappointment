<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UpdateUserController extends Controller
{
    public function update(Request $request){
        $user = Auth::user();
        $this->validate(request(), [
            'email' => 'unique:users,email,'.$user->id,
            'password' => 'required|confirmed|min:6'
        ]);

        //create post


        $user->mobile_num = $request->input('mobile');
        $user->email = $request->input('email');
        if(!empty($request->input('password'))){
            if($request->input('password')==$request->input('password_confirmation')){
                $user->password = Hash::make($request->input('password'));
            }
        }
        //$user->body = $request->input('body');
        $user->save();

        return redirect('/dashboard#settings');
    }
}

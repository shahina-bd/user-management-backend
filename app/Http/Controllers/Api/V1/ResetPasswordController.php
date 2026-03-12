<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function reset(Request $request) {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors()
            ],422);
        }


        $status = Password::broker()->reset(
            $request->only('token', 'email', 'password'),
            function($user, $password)
            {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
 
                $user->save();
            } 
        );

        return $status == Password::PasswordReset 
        ? response()->json(['status' => 'success', 'message' => 'Password has been reset successfully'],200) 
        : response()->json(['status' => 'error', 'message' => 'Failed to reset password'],422);

    }
}
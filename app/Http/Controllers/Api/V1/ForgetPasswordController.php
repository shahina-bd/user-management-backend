<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgetPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors()
            ],422);
        }

         $status = Password::broker()->sendResetLink($request->only('email'));

        return $status == Password::ResetLinkSent 
        ? response()->json(['status' => 'success', 'message' => 'Reset link sent to your email'],200) 
        : response()->json(['status' => 'error', 'message' => 'unable to sent mail'],422);
    }

}

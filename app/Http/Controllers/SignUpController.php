<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class SignUpController extends Controller
{
    /**
     * Check if the given username can be used for a new account
     * @param Illuminate\Http\Request
     */
    public function checkUsername(Request $request) {
        try {
            $rules = ['username' => 'required|max:30'];
            $validator = Validator::make($request->all(), $rules);

            if (!$validator->fails()) {
                $is_username_taken = User::where('username', $request->input('username'))->count() != 0;
                return response('', ($is_username_taken ? 409 : 200));
            } else {
                $errors = $validator->errors();
                if ($errors->has('username.required')) return response('', 404);
                elseif ($errors->has('username.max')) return response('😮 Wow, that username is too long!');
                throw new \Exception;
            }
        }
        catch (\Exception) {
            return response('', 500);
        }
    }
}

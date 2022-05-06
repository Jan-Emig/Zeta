<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Services\SignUpService;

class SignUpController extends Controller
{

    function __construct(SignUpService $sign_up_service) {
        $this->sign_up_service = $sign_up_service;
    }

    /**
     * Check if the given username can be used for a new account
     * @param Illuminate\Http\Request
     */
    public function checkUsername(Request $request) {
        try {
            $rules = ['username' => 'required|max:'.User::getMaxUsernameLength()];
            $msgs = [
                'username.required' => '🧐 Hmm...are you sure you entered an username?',
                'username.max' => '😮 Wow, that username is too long!'
            ];
            $validator = Validator::make($request->all(), $rules, $msgs);

            if (!$validator->fails()) {
                $is_username_taken = $this->sign_up_service->doesUsernameExists($request->input('username', ''));
                return response('', ($is_username_taken ? 409 : 200));
            } else {
                $errors = $validator->errors();
                return response($errors, 400);
            }
        }
        catch (\Exception) {
            return response('', 500);
        }
    }

    /**
     * Create a new user
     * @param Illuminate\Http\Request
     */
    public function signUp(Request $request) {
        try
        {
            $username = $request->input('username');
            $password = $request->input('password');
            $rules = [
                'username' => 'required|max:'.User::getMaxUsernameLength(),
                'password' => 'required|min:4'
            ];
            $validator = Validator::make($request->all(), $rules);

            if (!$validator->fails() && !User::firstWhere('username', $username)) {
                $was_successfull = $this->sign_up_service->signUp($username, $password);
                if (!$was_successfull) throw new \Exception;
                return response('', 200);
            } else {
                return response('', 400);
            }
        }
        catch (\Exception) {
            return response('', 500);
        }
    }
}

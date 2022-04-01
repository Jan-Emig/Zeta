<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Services\SignInService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class SignInController extends Controller
{

    function __construct(SignInService $sign_in_service)
    {
        $this->sign_in_service = $sign_in_service;
    }

    /**
     * Sign user in by using the provided user id and password
     * @param Illuminate\Http\Request
    **/
    public function SignIn(Request $request)
    {
        $rules = [
            'username' => 'required|max:30',
            'password' => 'required'
        ];

        $msgs = [
            'username.required' => '🧐 Hm, this user id seems quite empty...',
            'username.max' => '😮 Wow, that\'s quite a long username. You\'re sure it\'s correct?',
            'password.required' => '😵‍💫 Are you sure this password is correct?'
        ];

        $validator = Validator::make($request->all(), $rules, $msgs);

        if (!$validator->fails()) {
            try {
                return $this->sign_in_service->signIn($request->username, $request->password);
            }
            catch (Exception) {
                return response('', 505);
            }
        } else return response($validator->errors(), 400);
    }

}

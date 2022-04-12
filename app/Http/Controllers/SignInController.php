<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Services\SignInService;
use Exception;
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
            'password' => 'required',
            'app_uuid' => 'required|uuid',
        ];

        $msgs = [
            'username.required' => '🧐 Hm, this user id seems quite empty...',
            'username.max' => '😮 Wow, that\'s quite a long username. You\'re sure it\'s correct?',
            'password.required' => '😵‍💫 Are you sure this password is correct?',
            'app_uuid.required' => 'No app uuid provided',
            'app_uuid.uuid' => 'Invalid app uuid'
        ];

        $validator = Validator::make($request->all(), $rules, $msgs);

        if (!$validator->fails()) {
            try {
                $response = $this->sign_in_service->signIn($request, $request->username, $request->password, $request->app_uuid);
                return $response;
            }
            catch (Exception $e) {
                return dd($e);
                return response('', 500);
            }
        } else return response($validator->errors(), 400);
    }

}

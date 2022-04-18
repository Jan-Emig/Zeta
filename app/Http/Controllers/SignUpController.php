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
            $rules = ['username' => 'required|max:30'];
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
                // if ($errors->has('username.required')) return response('', 404);
                // elseif ($errors->has('username.max')) return response('😮 Wow, that username is too long!');
                // throw new \Exception;
            }
        }
        catch (\Exception $e) {
            return response('', 500);
        }
    }
}

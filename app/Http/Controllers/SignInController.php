<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SignInController extends Controller
{
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
            $user = User::firstWhere('username', $request->username);
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    if (Auth::attempt(['uuid' => $user->uuid, 'password' => $request->password])) return response('');
                    else return response('auth-failed', 401);
                } else return response('wrong-password', 401);
            } else return response('no-user', 404);
        } else return response($validator->errors(), 400);
    }

}

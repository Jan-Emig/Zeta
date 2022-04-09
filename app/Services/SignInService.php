<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SignInService
{


    /**
     * Sign user in and intialize a new session
     * @param Request $request
     * @param string $username
     * @param string $password
     * @return response(msg: string, http_code:int)
     */
    public function signIn($request, $username, $password)
    {
        $user = User::firstWhere('username', $username);
        if ($user) {
            if (Hash::check($password, $user->password)) {
                if (Auth::attempt(['uuid' => $user->uuid, 'password' => $password])) {
                    $request->session()->put('user', $user);
                    // $request->session()->regenerate();
                    // $response_data = array(
                    //     'username' => $user->username,
                    //     'remember_token' => $user->remember_token
                    // );
                    // return response($response_data);
                    return response('');
                }
                return response('auth-failed', 401);
            }
            return response('wrong-password', 401);
        }
        return response('no-user', 404);
    }
}

?>

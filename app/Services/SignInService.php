<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SignInService
{


    /**
     * Sign user in and intialize a new session
     * @param string $username
     * @param string $password
     * @return response(msg: string, http_code:int)
     */
    public function signIn($username, $password)
    {
        $user = User::firstWhere('username', $username);
        if ($user) {
            if (Hash::check($password, $user->password)) {
                if (Auth::attempt(['uuid' => $user->uuid, 'password' => $password])) return response('');
                else return response('auth-failed', 401);
            } else return response('wrong-password', 401);
        }
        return response('no-user', 404);
    }
}

?>

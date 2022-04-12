<?php

namespace App\Services;
use App\Models\User;
use App\Models\UserSession;
use App\Services\UserSessionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class SignInService
{

    function __construct()
    {
        $this->userSessionService =  new UserSessionService();
    }


    /**
     * Sign user in and intialize a new session
     * @param Request $request
     * @param string $username
     * @param string $password
     * @return response(msg: string, http_code:int)
     */
    public function signIn($request, $username, $password, $app_uuid)
    {
        $user = User::firstWhere('username', $username);
        if ($user) {
            if (Hash::check($password, $user->password)) {
                $session = UserSession::firstWhere('app_uuid', $app_uuid);
                $token = ($session)
                    ? $token = $this->userSessionService->updateUserSession($session)
                    :  $this->userSessionService->createUserSession($request, $app_uuid, $user);

                if (!$token || strlen($token) != 64) return response('', 409);

                return response('')
                    ->withCookie(cookie()->forever('s_token', $token));
            }
            return response('wrong-password', 401);
        }
        return response('no-user', 404);
    }
}

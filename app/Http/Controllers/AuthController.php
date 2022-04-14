<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Str;
use App\Models\UserSession;

class AuthController extends Controller
{

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }
    /**
     *
     * Checks if the user is authenticated and within a valid session
     * @param Request $request
     * @return response(is_authenticated: bool)
     */
    public function checkAuthentication(Request $request) {
        $app_uuid = $request->input('app_uuid');
        $s_token = $request->input('s_token');
        $u_uuid = $request->input('u_uuid');
        if (Str::isUuid($app_uuid) && Str::isUuid($u_uuid)) {
            $user_session = UserSession::join('users', 'user_id', '=', 'users.id')
                ->where('users.uuid', $u_uuid)
                ->where('app_uuid', $app_uuid)
                ->firstWhere('token', $s_token);
            if ($user_session) {
                $user_session->token = Str::random(env('SESSION_TOKEN_LENGTH'), 60);
                $user_session->save();
                return response($user_session->uuid);
            }
        }
        return response('', 401);
    }
}

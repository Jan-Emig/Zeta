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
        if (Str::isUuid($app_uuid)) {
            $user_session = UserSession::firstWhere('app_uuid');
            if ($user_session) {
                $user_session->uuid = Str::uuid();
                $user_session->save();
                return response($user_session->uuid);
            }
        }
        return response('', 401);
    }
}

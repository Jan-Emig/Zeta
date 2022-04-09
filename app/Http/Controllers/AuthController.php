<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

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
        if ($request->session?->get('key')) return response('OK', 200);
        return response('', 404);
    }
}

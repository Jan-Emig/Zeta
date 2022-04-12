<?php

namespace App\Services;
use \App\Models\UserSession;
use Illuminate\Support\Str;

class UserSessionService
{
    /**
     * Create a new user session connected with the provided app uuid
     * @param Illuminate\Http\Request $request
     * @param string $app_uuid
     * @param App\Models\User $user
     * @return string $session_token
     */
    public function createUserSession($request, $app_uuid, $user): string
    {
        try
        {
            $session = new UserSession();
            $session->user_id = $user->id;
            $session->app_uuid = $app_uuid;
            $session->ip = $request->ip();
            $session->token = Str::random(64);

            $session->save();
            return $session->token;
        }
        catch (\Exception $e) { }
        return '';
    }

    /**
     * Update an existing user session record by generating a new session token
     * @param App\Models\UserSession $session
     * @return string $token
     */
    public function updateUserSession(UserSession $session): string
    {
        try{
            $session->token = Str::random(64);
            $session->save();
            return $session->token;
        }
        catch (\Exception $e) { }
        return '';
    }
}

?>

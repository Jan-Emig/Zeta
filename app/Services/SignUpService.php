<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SignUpService {

    /**
     * Determines if the given username is already in use
     * @param string $username
     * @return bool
     */
    public function doesUsernameExists($username) {
        try {
            return strlen($username) > 0 && User::where('username', trim($username))->count() != 0;
        }
        catch (\Exception) {
            return true;
        }
    }

    /**
     * Create a new user profile with an given username and password
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function signUp($username, $password) {
        try {
            $user = new User;
            $user->username = $username;
            $user->password = Hash::make($password);
            $user->uuid = Str::uuid();
            $user->save();
            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }
}

?>

<?php

namespace App\Services;

use App\Models\User;

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
}

?>

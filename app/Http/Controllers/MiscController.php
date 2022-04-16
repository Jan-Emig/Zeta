<?php

namespace App\Http\Controllers;

use SplFileObject;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\MiscService;
use Illuminate\Support\Facades\DB;

class MiscController extends Controller
{
    function __construct(MiscService $misc_service) {
        $this->misc_service = $misc_service;
    }
    /**
     * Return 'pong' if the user pings
     * @param Request $requests
     * @return string
     */
    public function ping(Request $request) {
        return response('pong', 200);
    }

    /**
     * Generates a random username consisting of a random number of words
     * @param Request $request
     * @return string
     */
    public function generateUsername(Request $request) {
        try {
            return $this->misc_service->generateUsername();
        }
        catch (\Exception) {
            return response('', 500);
        }
    }
}

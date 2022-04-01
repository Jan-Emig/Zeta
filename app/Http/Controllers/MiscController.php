<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MiscController extends Controller
{
    /**
     * Return 'pong' if the user pings
     * @param Request $requests
     * @return string
     */
    public function ping(Request $request) {
        return response('pong', 200);
    }
}

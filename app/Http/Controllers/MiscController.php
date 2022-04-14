<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use SplFileObject;

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

    /**
     * Generates a random username consisting of a random number of words
     * @param Requesrt $request
     * @return string
     */
    public function generateUsername(Request $request) {
        $dict_file = new SplFileObject(storage_path('app/words_dict.txt'));
        if (!$dict_file->eof()) {
            $dict_file->seek(PHP_INT_MAX);
            $lines_total = $dict_file->key();
            for($idx = 0; $idx < 15; $idx++) {
                $nof_words = rand(1, 3);
                $nof_nums = rand(0, 4);
                $words = [];
                $nums = "";
                for ($i = 0; $i < $nof_words; $i++) {
                    $line = rand(0, $lines_total);
                    $dict_file->seek($line);
                    $words[$i] = trim(($i == 0) ? $dict_file->fgets() : ucfirst($dict_file->fgets()));
                }
                for ($i = 0; $i < $nof_nums; $i++) {
                    $nums .= strval(rand(0, 9));
                }
                $username = join("", $words).$nums;
                if (!User::firstWhere('username', $username)) return response($username, 200);
            }
        }
        return response('', 404);
    }
}

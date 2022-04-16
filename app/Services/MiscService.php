<?php

namespace App\Services;

use SplFileObject;
use App\Models\User;


class MiscService {
    /**
     * Generates a random username consisting of a random number of words and digits
     * @return string
     */
    public function generateUsername() {
        $MAX_USERNAME_LENGTH = 20;
        $dict_file = new SplFileObject(storage_path('app/words_dict.txt'));
        if (!$dict_file->eof()) {
            $dict_file->seek(PHP_INT_MAX);
            $lines_total = $dict_file->key();
            for($idx = 0; $idx < 15; $idx++) {
                $nof_words = rand(1, 3);
                $nof_nums = rand(0, 4);
                $words = [];
                $words_length = 0;
                $nums = "";
                for ($i = 0; $i < $nof_words; $i++) {
                    $line = rand(0, $lines_total);
                    $dict_file->seek($line);
                    $new_word = trim($dict_file->fgets());
                    if ($words_length + strlen($new_word) > $MAX_USERNAME_LENGTH) break;
                    $words[$i] = ($i == 0) ? $new_word : ucfirst($new_word);
                    $words_length += strlen($new_word);
                }
                for ($i = 0; $i < min($nof_nums, $MAX_USERNAME_LENGTH); $i++) {
                    $nums .= strval(rand(0, 9));
                }
                $username = join("", $words).$nums;
                if (!User::firstWhere('username', $username)) return response($username, 200);
            }
        } else throw new \Exception;
    }
}

?>

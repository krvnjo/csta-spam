<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Format the Input.
     */
    public function formatInput($input)
    {
        $words = explode(' ', $input);

        $formattedWords = array_map(function ($word) {
            $preserveWords = ['CSTA', 'STSN', 'IT', 'HM', 'TM', 'EDUC', 'HMTM', 'GYM', 'of', 'is', 'from', 'as', 'with', 'and', 'or'];
            if (in_array(strtoupper($word), array_map('strtoupper', $preserveWords))) {
                foreach ($preserveWords as $preserveWord) {
                    if (strcasecmp($word, $preserveWord) == 0) {
                        return $preserveWord;
                    }
                }
            }
            return ucfirst(strtolower($word));
        }, $words);

        return implode(' ', $formattedWords);
    }
}

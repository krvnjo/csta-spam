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

    /**
     * Format to Full Name.
     */
    public function formatFullName($firstName, $lastName)
    {
        return $firstName . ' ' . $lastName;
    }

    /**
     * Get the user details in audit.
     */
    public function getUserAuditDetails($audit)
    {
        return [
            'image' => asset('storage/img/user-images/' . ($audit ? $audit->causer->user_image : 'system.jpg')),
            'name' => $audit ? $this->formatFullName($audit->causer->fname, $audit->causer->lname) : 'CSTA-SPAM System',
        ];
    }
}

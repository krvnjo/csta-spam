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
     * Get the user details in audit.
     */
    public function getUserAuditDetails($audit)
    {
        return [
            'image' => asset('storage/img/user-images/' . ($audit ? ($audit->causer->user_image ?? 'system.jpg') : 'system.jpg')),
            'name' => $audit?->causer ? $audit->causer->name : 'CSTA-SPAM System',
        ];
    }

    public function formatName($fname, $mname, $lname)
    {
        if (empty($mname)) {
            return ucwords(trim($fname)) . ' ' . ucwords(trim($lname));
        } else {
            return ucwords(trim($fname)) . ' ' . strtoupper(substr(ucwords(trim($mname)), 0, 1)) . '. ' . ucwords(trim($lname)); // First Name M. Last Name
        }
    }
}

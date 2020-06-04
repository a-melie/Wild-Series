<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input): string
    {
        $cleanInput = iconv( 'UTF-8', 'ASCII//TRANSLIT//IGNORE', $input );
        $cleanInput =  preg_replace('/[^a-zA-Z0-9 ]/', '', $cleanInput);
        $cleanInput = trim(strip_tags($cleanInput));
        $cleanInput = preg_replace('/\s+/', '-', $cleanInput);
        $cleanInput = mb_strtolower($cleanInput);

        return  $cleanInput;
    }

}

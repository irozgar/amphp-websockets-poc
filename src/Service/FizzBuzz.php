<?php
declare(strict_types=1);

namespace Irozgar\WebsocketsPOC\Service;

class FizzBuzz
{
    public function run($max): array
    {
        $result = [];

        foreach (range(1, $max) as $number) {
            $item = '';
            if ($number%3 === 0) {
                $item .= 'Fizz';
            }
            if ($number%5 === 0) {
                $item .= 'Buzz';
            }
            if ($item === '') {
                $item = $number;
            }
            $result[] = $item;
        }

        return $result;
    }
}

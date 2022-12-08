<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2015;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function str_split;

final class Day1 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $instructions = $this->input[0];
        $floor = 0;
        foreach (str_split($instructions) as $item) {
            $item === '(' ? $floor++ : $floor--;
        }

        $this->info('To what floor do the instructions take Santa?');
        $this->line($floor);
    }

    public function two(): void
    {
        $instructions = $this->input[0];
        $floor = 0;
        $character = 0;
        foreach (str_split($instructions) as $index => $item) {
            $item === '(' ? $floor++ : $floor--;

            if ($floor === -1) {
                $character = $index;
                break;
            }
        }

        $this->info('To what floor do the instructions take Santa?');
        $this->line(++$character);
    }
}

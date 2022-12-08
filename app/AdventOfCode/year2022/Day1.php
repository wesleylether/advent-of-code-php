<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2022;

use App\AdventOfCode\BaseAdventOfCodeDay;

final class Day1 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        // create part 1
        $list = $this->getList();

        $this->info('Find the Elf carrying the most Calories. How many total Calories is that Elf carrying?');
        $this->line(max($list));
    }

    public function two(): void
    {
        // create part 2
        $list = $this->getList();

        rsort($list);

        $this->info('Find the top three Elves carrying the most Calories. How many Calories are those Elves carrying in total?');
        $this->line(array_sum(array_slice($list, 0, 3)));
    }

    protected function getList(): array
    {
        $index = 1;

        return array_reduce(
            $this->input,
            static function ($carry, $item) use (&$index) {
                if (empty($item)) {
                    $index++;

                    return $carry;
                }

                if (! isset($carry[$index])) {
                    $carry[$index] = 0;
                }

                $carry[$index] += (int) $item;

                return $carry;
            },
        );
    }
}

<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2022;

use App\AdventOfCode\BaseAdventOfCodeDay;

final class Day3 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $score = 0;

        foreach ($this->input as $rucksack) {
            $itemCount = (int) (strlen($rucksack) * 0.5);
            [$left, $right] = str_split($rucksack, $itemCount);
            $left = str_split($left);
            $right = str_split($right);
            $intersect = array_values(array_unique(array_intersect($left, $right)));
            $score += $this->getCharPoints($intersect[0]);
        }

        $this->info('Find the item type that appears in both compartments of each rucksack. What is the sum of the priorities of those item types?');
        $this->line($score);
    }

    public function two(): void
    {
        $score = 0;

        foreach (array_chunk($this->input, 3) as $rucksacks) {
            [$rucksack1, $rucksack2, $rucksack3] = array_map(static fn ($rucksack) => str_split($rucksack), $rucksacks);
            $intersect = array_values(array_unique(array_intersect($rucksack1, $rucksack2, $rucksack3)));
            $score += $this->getCharPoints($intersect[0]);
        }

        $this->info('Find the item type that corresponds to the badges of each three-Elf group. What is the sum of the priorities of those item types?');
        $this->line($score);
    }

    protected function getCharPoints(string $char): int
    {
        $lowerCase = range('a', 'z');
        $upperCase = range('A', 'Z');

        if (ctype_lower($char)) {
            return array_search($char, $lowerCase, true) + 1;
        }

        return array_search($char, $upperCase, true) + 27;
    }
}

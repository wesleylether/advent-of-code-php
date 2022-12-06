<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2022;

use App\AdventOfCode\BaseAdventOfCodeDay;

final class Day4 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $count = 0;
        foreach ($this->getPairs() as [$a1, $a2, $b1, $b2]) {
            if ($a1 >= $b1 && $a2 <= $b2) {
                $count++;
                continue;
            }

            if ($b1 >= $a1 && $b2 <= $a2) {
                $count++;
            }
        }

        $this->info('In how many assignment pairs does one range fully contain the other?');
        $this->line($count);
    }

    public function two(): void
    {
        $count = 0;
        foreach ($this->getPairs() as [$a1, $a2, $b1, $b2]) {
            $rangeA = range($a1, $a2);
            $rangeB = range($b1, $b2);
            if(count(array_intersect($rangeA, $rangeB))) {
                $count++;
            }
        }

        $this->info('In how many assignment pairs do the ranges overlap?');
        $this->line($count);
    }

    protected function getPairs(): \Generator
    {
       foreach ($this->input as $item) {
            preg_match('/(\d+)-(\d+),(\d+)-(\d+)/', $item, $matches);
            [,$a1, $a2, $b1, $b2] = $matches;
            yield [$a1, $a2, $b1, $b2];
        }
    }
}

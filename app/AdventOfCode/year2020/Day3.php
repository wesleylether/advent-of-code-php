<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;

class Day3 extends BaseAdventOfCodeDay
{
    public function getTotal(): array
    {
        $modulo = \strlen($this->input[0]);
        $slopes = [[1, 1], [3, 1], [5, 1], [7, 1], [1, 2]];

        $total = [];
        foreach ($slopes as $slope) {
            [$right, $down] = $slope;

            $pos = $right;
            $line = $down;
            $trees = 0;
            $space = 0;
            while ($line < count($this->input)) {
                $item = $this->input[$line][$pos % $modulo];
                if ($item === '#') {
                    $trees++;
                } else {
                    $space++;
                }

                $line += $down;
                $pos += $right;
            }

            $total["$right-$down"] = $trees;
        }

        return $total;
    }

    public function one(): void
    {
        $trees = $this->getTotal()['3-1'];
        $this->line("Aantal bomen (slope 3-1): $trees");
    }

    public function two(): void
    {
        $totalMultiplied = array_reduce($this->getTotal(), function (
            $carry,
            $item,
        ) {
            if ($carry) {
                return $carry * $item;
            }

            return $item;
        });

        $this->line("product of all slopes: $totalMultiplied");
    }
}

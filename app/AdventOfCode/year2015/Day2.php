<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2015;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function array_map;
use function array_pop;
use function dd;
use function min;
use function preg_match;

final class Day2 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $squareFeetOfWrappingPaper = 0;
        foreach ($this->input as $dimension) {
            preg_match('/^(\d+)x(\d+)x(\d+)$/', $dimension, $matches);
            [, $l, $w, $h] = array_map(
                static fn($match) => (int) $match,
                $matches,
            );

            $lw = $l * $w;
            $lh = $l * $h;
            $wh = $w * $h;

            $squareFeetOfWrappingPaper +=
                2 * $lw + 2 * $lh + 2 * $wh + min([$lw, $lh, $wh]);
        }

        $this->info(
            'How many total square feet of wrapping paper should they order?',
        );
        $this->line($squareFeetOfWrappingPaper);
    }

    public function two(): void
    {
        $ribbon = 0;
        foreach ($this->input as $dimension) {
            preg_match('/^(\d+)x(\d+)x(\d+)$/', $dimension, $matches);
            [, $l, $w, $h] = array_map(
                static fn($match) => (int) $match,
                $matches,
            );
            $sides = [$l, $w, $h];
            sort($sides);
            array_pop($sides);

            $ribbon += $sides[0] * 2 + $sides[1] * 2;
            $ribbon += $l * $w * $h;
        }

        $this->info('How many total feet of ribbon should they order?');
        $this->line($ribbon);
    }
}

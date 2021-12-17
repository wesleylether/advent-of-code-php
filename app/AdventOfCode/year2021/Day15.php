<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use App\AdventOfCode\utils\PQueue;
use function array_map;

final class Day15 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $this->info(
            'What is the lowest total risk of any path from the top left to the bottom right?',
        );
        $this->line($this->solve(1));
    }

    public function two(): void
    {
        $this->info(
            'Using the full map, what is the lowest total risk of any path from the top left to the bottom right?',
        );
        $this->line($this->solve(5));
    }

    protected function solve(int $nTiles): int
    {
        $grid = grid($this->input);
        $rCount = count($grid);
        $cCount = count($grid[0]);
        $dr = [-1, 0, 1, 0];
        $dc = [0, 1, 0, -1];

        $d = array_map(
            static fn() => array_map(
                static fn() => null,
                range(0, $nTiles * $cCount),
            ),
            range(0, $nTiles * $rCount),
        );
        $q = new PQueue();
        $q->insert([0, 0], 0);
        $q->setExtractFlags(PQueue::EXTR_BOTH);

        while (!$q->isEmpty()) {
            $item = $q->extract();
            [$r, $c] = $item['data'];
            $dist = $item['priority'];

            if (
                $r < 0 ||
                $r >= $nTiles * $rCount ||
                $c < 0 ||
                $c >= $nTiles * $cCount
            ) {
                continue;
            }

            $val =
                $grid[$r % $rCount][$c % $cCount] +
                floor($r / $rCount) +
                floor($c / $cCount);
            while ($val > 9) {
                $val -= 9;
            }
            $rcCost = $dist + $val;

            if ($d[$r][$c] === null || $rcCost < $d[$r][$c]) {
                $d[$r][$c] = $rcCost;
            } else {
                continue;
            }

            if ($r === $nTiles * $rCount - 1 && $c === $nTiles * $cCount - 1) {
                break;
            }

            foreach (range(0, 3) as $dir) {
                $rr = $r + $dr[$dir];
                $cc = $c + $dc[$dir];
                $q->insert([$rr, $cc], $d[$r][$c]);
            }
        }

        return (int) $d[$nTiles * $rCount - 1][$nTiles * $cCount - 1] -
            $grid[0][0];
    }
}

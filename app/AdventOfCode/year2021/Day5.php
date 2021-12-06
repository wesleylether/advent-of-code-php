<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function abs;
use function preg_match;
use function range;

final class Day5 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $grid = $this->getGrid();

        foreach ($this->input as $input) {
            [$x1, $y1, $x2, $y2] = $this->getPointData($input);

            if ($x1 === $x2) {
                foreach (range($y1, $y2) as $yValue) {
                    $grid[$x1][$yValue] = $this->updatePoint(
                        $grid[$x1][$yValue],
                    );
                }
            }

            if ($y1 === $y2) {
                foreach (range($x1, $x2) as $xValue) {
                    $grid[$xValue][$y1] = $this->updatePoint(
                        $grid[$xValue][$y1],
                    );
                }
            }
        }

        $this->info(
            'Consider only horizontal and vertical lines. At how many points do at least two lines overlap?',
        );
        $this->line($this->calculateGridPoints($grid));
    }

    public function two(): void
    {
        $grid = $this->getGrid();

        foreach ($this->input as $input) {
            [$x1, $y1, $x2, $y2] = $this->getPointData($input);

            $dx = $x1 < $x2 ? 1 : ($x1 > $x2 ? -1 : 0);
            $dy = $y1 < $y2 ? 1 : ($y1 > $y2 ? -1 : 0);

            $length = max(abs($x2 - $x1), abs($y2 - $y1));
            for (
                $i = 0, $x = $x1, $y = $y1;
                $i <= $length;
                $i++, $x += $dx, $y += $dy
            ) {
                $grid[$x][$y] = $this->updatePoint($grid[$x][$y]);
            }
        }

        $this->info(
            'Consider all of the lines. At how many points do at least two lines overlap?',
        );
        $this->line($this->calculateGridPoints($grid));
    }

    protected function getGrid(): array
    {
        $grid = [];
        for ($i = 0; $i < 1000; $i++) {
            for ($j = 0; $j < 1000; $j++) {
                $grid[$i][$j] = '.';
            }
        }

        return $grid;
    }

    protected function getPointData(string $input): array
    {
        preg_match('/^(\d+),(\d+)\s->\s(\d+),(\d+)$/', $input, $matches);
        [, $x1, $y1, $x2, $y2] = $matches;
        return [(int) $x1, (int) $y1, (int) $x2, (int) $y2];
    }

    protected function updatePoint(string|int $pointValue): int
    {
        if ($pointValue === '.') {
            return 1;
        }

        return $pointValue + 1;
    }

    protected function calculateGridPoints(array $grid): int
    {
        $count = 0;
        foreach ($grid as $row) {
            foreach ($row as $item) {
                if ($item >= 2) {
                    $count++;
                }
            }
        }

        return $count;
    }
}

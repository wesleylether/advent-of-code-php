<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function array_reduce;
use function array_shift;
use function implode;
use function preg_match;

final class Day13 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $count = 0;
        [$grid, $folds] = $this->getData();

        [$direction, $point] = array_shift($folds);
        $grid = $this->fold($grid, $direction, $point);

        foreach ($grid as $row) {
            foreach ($row as $value) {
                if ($value === '#') {
                    $count++;
                }
            }
        }

        $this->info(
            'How many dots are visible after completing just the first fold instruction on your transparent paper?',
        );
        $this->line($count);
    }

    public function two(): void
    {
        [$grid, $folds] = $this->getData();

        while ($folds) {
            [$direction, $point] = array_shift($folds);
            $grid = $this->fold($grid, $direction, $point);
        }

        $this->info(
            'What code do you use to activate the infrared thermal imaging camera system?',
        );

        foreach ($grid as $row) {
            $this->line(implode($row));
        }
    }

    protected function fold(array $grid, string $direction, int $point): array
    {
        $newGrid = [];
        switch ($direction) {
            case 'x':
                foreach ($grid as $y => $row) {
                    $newRow = [];
                    foreach ($row as $x => $value) {
                        if ($x === $point) {
                            continue;
                        }

                        if ($x > $point) {
                            if ($value === '#') {
                                $newRow[$point - ($x - $point)] = $value;
                            } else {
                                $newRow[$point - ($x - $point)] =
                                    $row[$point - ($x - $point)];
                            }
                        } else {
                            $newRow[$x] = $value;
                        }
                    }
                    $newGrid[$y] = $newRow;
                }
                break;
            case 'y':
                foreach ($grid as $y => $row) {
                    if ($y === $point) {
                        continue;
                    }

                    if ($y > $point) {
                        foreach ($row as $x => $value) {
                            if ($value === '#') {
                                $newGrid[$point - ($y - $point)][$x] = $value;
                            } else {
                                $newGrid[$point - ($y - $point)][$x] =
                                    $grid[$point - ($y - $point)][$x];
                            }
                        }
                    } else {
                        $newGrid[$y] = $row;
                    }
                }
                break;
        }

        return $newGrid;
    }

    protected function getData(): array
    {
        $points = [];
        $grid = [];
        $folds = [];
        foreach ($this->input as $line) {
            if (preg_match('/^(\d+),(\d+)$/', $line, $matches)) {
                [, $x, $y] = $matches;
                $points[] = [(int) $x, (int) $y];
            }

            if (preg_match('/^fold along (x|y)=(\d+)$/', $line, $matches)) {
                [, $pos, $d] = $matches;
                $folds[] = [$pos, (int) $d];
            }
        }

        [$xMax, $yMax] = array_reduce(
            $points,
            static function ($carry, $current) {
                $max = $carry;
                [$x, $y] = $current;

                if ($max[0] < $x) {
                    $max[0] = $x;
                }
                if ($max[1] < $y) {
                    $max[1] = $y;
                }

                return $max;
            },
            [0, 0],
        );

        foreach (range(0, $yMax) as $yIndex) {
            foreach (range(0, $xMax) as $xIndex) {
                $grid[$yIndex][$xIndex] = '.';
            }
        }

        foreach ($points as [$x, $y]) {
            $grid[$y][$x] = '#';
        }

        return [$grid, $folds];
    }
}

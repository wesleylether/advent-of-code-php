<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function array_product;
use function array_shift;
use function array_slice;
use function in_array;

final class Day9 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $grid = $this->getGrid();
        $lowPoints = 0;
        foreach ($grid as $y => $row) {
            foreach ($row as $x => $point) {
                $lowPoint = true;
                if (isset($grid[$y][$x - 1])) {
                    $left = $grid[$y][$x - 1];
                    if ($left <= $point) {
                        $lowPoint = false;
                    }
                }
                if ($lowPoint && isset($grid[$y][$x + 1])) {
                    $right = $grid[$y][$x + 1];
                    if ($right <= $point) {
                        $lowPoint = false;
                    }
                }
                if ($lowPoint && isset($grid[$y - 1][$x])) {
                    $up = $grid[$y - 1][$x];
                    if ($up <= $point) {
                        $lowPoint = false;
                    }
                }
                if ($lowPoint && isset($grid[$y + 1][$x])) {
                    $down = $grid[$y + 1][$x];
                    if ($down <= $point) {
                        $lowPoint = false;
                    }
                }

                if ($lowPoint) {
                    $lowPoints += $point + 1;
                }
            }
        }

        $this->info(
            'Find all of the low points on your heightmap. What is the sum of the risk levels of all low points on your heightmap?',
        );
        $this->line($lowPoints);
    }

    public function two(): void
    {
        $grid = $this->getGrid();
        $basins = [];
        $seen = [];
        foreach ($grid as $y => $row) {
            foreach ($row as $x => $point) {
                if ($point !== 9 && ! in_array("$y|$x", $seen, true)) {
                    $basinSize = 0;
                    $queue = [[$y, $x]];
                    while (count($queue) > 0) {
                        [$yy, $xx] = array_shift($queue);
                        if (in_array("$yy|$xx", $seen, true)) {
                            continue;
                        }
                        $seen[] = "$yy|$xx";
                        $basinSize++;
                        if (isset($grid[$yy][$xx - 1])) {
                            $d = $grid[$yy][$xx - 1];
                            if ($d !== 9) {
                                $queue[] = [$yy, $xx - 1];
                            }
                        }
                        if (isset($grid[$yy][$xx + 1])) {
                            $d = $grid[$yy][$xx + 1];
                            if ($d !== 9) {
                                $queue[] = [$yy, $xx + 1];
                            }
                        }
                        if (isset($grid[$yy - 1][$xx])) {
                            $d = $grid[$yy - 1][$xx];
                            if ($d !== 9) {
                                $queue[] = [$yy - 1, $xx];
                            }
                        }
                        if (isset($grid[$yy + 1][$xx])) {
                            $d = $grid[$yy + 1][$xx];
                            if ($d !== 9) {
                                $queue[] = [$yy + 1, $xx];
                            }
                        }
                    }
                    $basins[] = $basinSize;
                }
            }
        }

        sort($basins);
        $biggest = array_slice($basins, -3, 3);

        $this->info(
            'What do you get if you multiply together the sizes of the three largest basins?',
        );
        $this->line(array_product($biggest));
    }

    protected function getGrid(): array
    {
        $grid = [];
        foreach ($this->input as $item) {
            $grid[] = numbers($item);
        }

        return $grid;
    }
}

<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;

final class Day11 extends BaseAdventOfCodeDay
{
    protected array $grid = [];

    protected int $flashes = 0;

    public function one(): void
    {
        $this->grid = grid($this->input);
        $day = 0;

        while (true) {
            $day++;
            // add 1 for each gridItem
            foreach ($this->grid as $y => $row) {
                foreach ($row as $x => $item) {
                    $this->grid[$y][$x]++;
                }
            }

            // if 10 flash
            foreach ($this->grid as $y => $row) {
                foreach ($row as $x => $item) {
                    if ($this->grid[$y][$x] === 10) {
                        $this->flash($y, $x);
                    }
                }
            }

            if ($day === 100) {
                $this->info(
                    'Given the starting energy levels of the dumbo octopuses in your cavern, simulate 100 steps. How many total flashes are there after 100 steps?',
                );
                $this->line($this->flashes);
            }

            $done = true;
            // all the same
            foreach ($this->grid as $y => $row) {
                foreach ($row as $x => $item) {
                    if ($this->grid[$y][$x] === -1) {
                        $this->grid[$y][$x] = 0;
                    } else {
                        $done = false;
                    }
                }
            }
            if ($done) {
                $this->info(
                    'If you can calculate the exact moments when the octopuses will all flash simultaneously, you should be able to navigate through the cavern. What is the first step during which all octopuses flash?',
                );
                $this->line($day);
                break;
            }
        }
    }

    public function two(): void
    {
        $this->one();
    }

    protected function flash(int $y, int $x): void
    {
        $this->flashes++;
        $this->grid[$y][$x] = -1;

        foreach ([-1, 0, 1] as $dy) {
            foreach ([-1, 0, 1] as $dx) {
                $yy = $y + $dy;
                $xx = $x + $dx;
                if (
                    isset($this->grid[$yy][$xx]) &&
                    $this->grid[$yy][$xx] !== -1
                ) {
                    $this->grid[$yy][$xx]++;
                    if ($this->grid[$yy][$xx] >= 10) {
                        $this->flash($yy, $xx);
                    }
                }
            }
        }
    }
}

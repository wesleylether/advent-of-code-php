<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function array_map;
use function explode;

final class Day7 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $crabs = $this->getPuzzleInput();
        sort($crabs);
        $average = $crabs[count($crabs) / 2];

        $fuel = 0;
        foreach ($crabs as $crab) {
            $fuel += abs($crab - $average);
        }

        $this->info(
            'Determine the horizontal position that the crabs can align to using the least fuel possible. How much fuel must they spend to align to that position?',
        );
        $this->line($fuel);
    }

    public function two(): void
    {
        // TODO: Implement two() method.
    }

    protected function getPuzzleInput(): array
    {
        return array_map(
            static fn($number) => (int) $number,
            explode(',', $this->input[0]),
        );
    }
}

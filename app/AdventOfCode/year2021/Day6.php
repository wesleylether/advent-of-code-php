<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function array_map;
use function dd;
use function explode;

final class Day6 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $fish = $this->getInputNumbers();
        $day = 0;
        while ($day < 80) {
            $fishToAdd = 0;
            foreach ($fish as $index => $number) {
                if (--$number < 0) {
                    $fishToAdd++;
                    $fish[$index] = 6;
                    continue;
                }
                $fish[$index] = $number;
            }

            for ($i = 0; $i < $fishToAdd; $i++) {
                $fish[] = 8;
            }

            $day++;
        }

        $this->info(
            'Find a way to simulate lanternfish. How many lanternfish would there be after 80 days?',
        );
        $this->line(count($fish));
    }

    public function two(): void
    {
        // TODO: Implement two() method.
    }

    protected function getInputNumbers(): array
    {
        return array_map(
            static fn($number) => (int) $number,
            explode(',', $this->input[0]),
        );
    }
}

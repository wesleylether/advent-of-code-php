<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function array_key_exists;
use function array_map;
use function array_reduce;
use function array_sum;
use function explode;
use function ksort;

final class Day6 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $fishCount = $this->getFishAfterDays(80);

        $this->info(
            'Find a way to simulate lanternfish. How many lanternfish would there be after 80 days?',
        );
        $this->line($fishCount);
    }

    public function two(): void
    {
        $fishCount = $this->getFishAfterDays2(256);

        $this->info('How many lanternfish would there be after 256 days?');
        $this->line($fishCount);
    }

    protected function getInputNumbers(): array
    {
        return array_map(
            static fn ($number) => (int) $number,
            explode(',', $this->input[0]),
        );
    }

    protected function getFishAfterDays(int $days): int
    {
        $fish = $this->getInputNumbers();
        $day = 0;
        while ($day < $days) {
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

        return count($fish);
    }

    protected function getFishAfterDays2(int $days): int
    {
        $fish = $this->getInputNumbers();
        $matrix = array_reduce(
            $fish,
            static function ($carry, $current) {
                if (! array_key_exists($current, $carry)) {
                    $carry[(int) $current] = 1;
                } else {
                    $carry[(int) $current]++;
                }

                return $carry;
            },
            [],
        );

        ksort($matrix);

        $day = 0;
        while ($day < $days) {
            $dMatrix = [];
            foreach ($matrix as $dDay => $fishCount) {
                $dMatrix[$dDay - 1] = $fishCount;
            }

            if (array_key_exists(-1, $dMatrix)) {
                $fishToReproduce = $dMatrix[-1];
                unset($dMatrix[-1]);

                if (array_key_exists(6, $dMatrix)) {
                    $dMatrix[6] += $fishToReproduce;
                } else {
                    $dMatrix[6] = $fishToReproduce;
                }

                $dMatrix[8] = $fishToReproduce;
            }

            $matrix = $dMatrix;
            ksort($matrix);

            $day++;
        }

        return array_sum($matrix);
    }
}

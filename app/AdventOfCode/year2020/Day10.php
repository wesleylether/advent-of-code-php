<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;

class Day10 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $current = 0;
        $joltage = [
            1 => 0,
            3 => 0,
        ];
        foreach ($this->getSortedInput() as $adapter) {
            $joltage[abs($current - $adapter)]++;
            $current = $adapter;
        }
        $joltage[3]++;

        $this->info(
            'What is the number of 1-jolt differences multiplied by the number of 3-jolt differences?',
        );
        $this->line($joltage[1] * $joltage[3]);
    }

    public function two(): void
    {
        $map = array_fill_keys($this->getSortedInput(), 0);
        ksort($map);
        $map[0] = 1;

        array_walk($map, static function (&$item, $key) use (&$map) {
            $item =
                ($map[$key - 1] ?? 0) +
                ($map[$key - 2] ?? 0) +
                ($map[$key - 3] ?? 0);
        });

        $this->info(
            'What is the total number of distinct ways you can arrange the adapters to connect the charging outlet to your device?',
        );
        $this->line(max($map));
    }

    public function getSortedInput(): array
    {
        $input = \array_map(
            static fn ($adapter) => (int) $adapter,
            $this->input,
        );
        \sort($input);

        return $input;
    }
}

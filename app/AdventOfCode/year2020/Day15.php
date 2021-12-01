<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function Psy\debug;

class Day15 extends BaseAdventOfCodeDay
{
    protected int $turn = 1;
    protected array $numbers;
    protected array $count;

    public function one(): void
    {
        $input = \array_reverse(
            \array_map(static fn($value) => (int) $value, $this->input),
        );

        $this->info('what will be the 2020th number spoken?');
        $this->line($this->game($input, 2020));
    }

    public function two(): void
    {
        $input = [];
        foreach ($this->input as $index => $number) {
            $input[$number] = $index;
        }

        $this->info('what will be the 30000000th number spoken?');
        $this->line($this->game2($input, 30000000));
    }

    protected function game(array $input, int $turn): int
    {
        while (count($input) !== $turn) {
            $lastDigit = \array_shift($input);
            if (!\in_array($lastDigit, $input, true)) {
                \array_unshift($input, 0, $lastDigit);
            } else {
                $stepsBack = \array_search($lastDigit, $input, true);
                \array_unshift($input, $lastDigit);
                \array_unshift($input, ++$stepsBack);
            }
        }

        return $input[0];
    }

    protected function game2(array $input, int $turn): int
    {
        $number = 0;
        $startIndex = count($input);
        for ($i = $startIndex; $i <= $turn - 2; $i++) {
            if (\array_key_exists($number, $input)) {
                $lastIndex = $input[$number];
                $input[$number] = $i;
                $number = $i - $lastIndex;
            } else {
                $input[$number] = $i;
            }

            if ($i % 100000 === 0) {
                $time = now()->format('H:m:s');
                $this->line("$time - $i");
            }
        }

        return $number;
    }
}

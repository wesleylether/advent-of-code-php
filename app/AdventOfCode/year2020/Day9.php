<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;

class Day9 extends BaseAdventOfCodeDay
{
    private const PREAMBLE_COUNT = 25;

    public function one(): void
    {
        $this->info(
            'What is the first number that does not have this property?',
        );
        $this->line($this->getData());
    }

    public function two(): void
    {
        $this->info(
            'What is the encryption weakness in your XMAS-encrypted list of numbers?',
        );
        $this->line(
            $this->findContiguousNumbers($this->input, $this->getData()),
        );
    }

    public function getData(): int
    {
        $list = $this->input;

        $preambleNumbersList = \array_splice($list, 0, self::PREAMBLE_COUNT);
        $sum = (int) $list[0];
        while (count($list) > 0) {
            if ($this->isSumPossible($preambleNumbersList, $sum)) {
                \array_shift($preambleNumbersList);
                $preambleNumbersList[] = \array_shift($list);
                $sum = (int) $list[0];
                continue;
            }

            break;
        }

        return $sum;
    }

    private function isSumPossible(array $preambleNumbersList, int $sum): bool
    {
        foreach ($preambleNumbersList as $indexA => $numberA) {
            foreach ($preambleNumbersList as $indexB => $numberB) {
                if ($indexA !== $indexB && $numberA + $numberB === $sum) {
                    return true;
                }
            }
        }
        return false;
    }

    private function findContiguousNumbers(
        array $list,
        int $breakingNumber,
    ): int {
        $length = count($list);

        for ($size = 2; ; ++$size) {
            for ($i = 0; $i < $length - $size; ++$i) {
                $numbers = \array_slice($list, $i, $size);
                if (\array_sum($numbers) === $breakingNumber) {
                    return \min($numbers) + \max($numbers);
                }
            }
        }
    }
}

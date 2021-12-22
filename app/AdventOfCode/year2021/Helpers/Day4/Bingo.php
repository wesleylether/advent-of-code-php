<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021\Helpers\Day4;

use function array_merge;
use function array_shift;
use function in_array;

final class Bingo
{
    public function __construct(public array $rows = [])
    {
    }

    public function addBingoNumber(int $bingoNumber): void
    {
        foreach ($this->rows as &$row) {
            foreach ($row as $number => $called) {
                if ($number === $bingoNumber) {
                    $row[$bingoNumber] = true;
                    break 2;
                }
            }
        }
    }

    public function hasBingo(): bool
    {
        foreach ($this->rows as $row) {
            if (in_array(false, $row, true) === false) {
                return true;
            }
        }

        $rows = array_merge([], $this->rows);
        $index = 0;
        while ($index < 5) {
            $one = array_shift($rows[0]);
            $two = array_shift($rows[1]);
            $three = array_shift($rows[2]);
            $four = array_shift($rows[3]);
            $five = array_shift($rows[4]);

            if (
                in_array(false, [$one, $two, $three, $four, $five], true) ===
                false
            ) {
                return true;
            }

            $index++;
        }

        return false;
    }

    public function getSumOfNotCalled(): int
    {
        $count = 0;

        foreach ($this->rows as $row) {
            foreach ($row as $number => $called) {
                if (!$called) {
                    $count += $number;
                }
            }
        }

        return $count;
    }
}

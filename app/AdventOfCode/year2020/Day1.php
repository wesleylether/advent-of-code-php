<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;

class Day1 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        foreach ($this->input as $number1) {
            foreach ($this->input as $number2) {
                $number1 = (int) $number1;
                $number2 = (int) $number2;
                if ($number1 + $number2 === 2020) {
                    $product = $number1 * $number2;
                    $this->line("$number1 + $number2 = 2020");
                    $this->line("$number1 * $number2 = $product");
                    break 2;
                }
            }
        }
    }

    public function two(): void
    {
        foreach ($this->input as $number1) {
            foreach ($this->input as $number2) {
                foreach ($this->input as $number3) {
                    $number1 = (int) $number1;
                    $number2 = (int) $number2;
                    $number3 = (int) $number3;

                    if ($number1 + $number2 + $number3 === 2020) {
                        $product = $number1 * $number2 * $number3;
                        $this->line("$number1 + $number2 + $number3 = 2020");
                        $this->line("$number1 * $number2 * $number3 = $product");
                        break 3;
                    }
                }
            }
        }
    }
}

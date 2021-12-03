<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function array_map;
use function array_reduce;
use function bindec;
use function str_split;
use function strlen;
use function substr;

final class Day3 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $calculation = [];
        foreach ($this->input as $index => $item) {
            $values = array_map(
                static fn($item) => (int) $item,
                str_split($item),
            );

            if ($index === 0) {
                foreach ($values as $place => $value) {
                    $calculation[$place] = 0;
                }
            }

            foreach ($values as $place => $value) {
                if ($value === 0) {
                    $calculation[$place]--;
                } else {
                    $calculation[$place]++;
                }
            }
        }

        $gamma = '';
        $epsilon = '';
        foreach ($calculation as $value) {
            $gamma .= $value > 0 ? '1' : '0';
            $epsilon .= $value > 0 ? '0' : '1';
        }

        $this->info(
            'Use the binary numbers in your diagnostic report to calculate the gamma rate and epsilon rate, then multiply them together. What is the power consumption of the submarine? (Be sure to represent your answer in decimal, not binary.)',
        );
        $this->line(bindec($gamma) * bindec($epsilon));
    }

    public function two(): void
    {
        $oxygen = $this->calculate($this->input, 'more', '1');
        $co2 = $this->calculate($this->input, 'less', '0');

        $this->info(
            'Use the binary numbers in your diagnostic report to calculate the oxygen generator rating and CO2 scrubber rating, then multiply them together. What is the life support rating of the submarine? (Be sure to represent your answer in decimal, not binary.)',
        );
        $this->line(bindec($oxygen) * bindec($co2));
    }

    protected function calculate(array $input, string $type, string $ending)
    {
        $calculate = $input;
        $size = strlen($input[0]);
        $index = -1;
        while (count($calculate) > 1) {
            $index++;
            if ($index === $size) {
                break;
            }

            $result = array_reduce(
                $calculate,
                static function ($carry, $item) use ($index) {
                    if (str_split($item)[$index] === '0') {
                        $carry['0'][] = $item;
                    } else {
                        $carry['1'][] = $item;
                    }

                    return $carry;
                },
                [
                    '0' => [],
                    '1' => [],
                ],
            );

            switch ($type) {
                case 'more':
                    if (count($result['0']) === count($result['1'])) {
                        $calculate = $result['1'];
                    } elseif (count($result['0']) > count($result['1'])) {
                        $calculate = $result['0'];
                    } else {
                        $calculate = $result['1'];
                    }
                    break;
                case 'less':
                    if (count($result['0']) === count($result['1'])) {
                        $calculate = $result['0'];
                    } elseif (count($result['0']) < count($result['1'])) {
                        $calculate = $result['0'];
                    } else {
                        $calculate = $result['1'];
                    }
                    break;
            }
        }

        return $calculate[0];
    }
}

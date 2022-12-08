<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function array_diff;
use function array_intersect;
use function array_map;
use function count;
use function explode;
use JetBrains\PhpStorm\Pure;
use function str_split;

final class Day8 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $input = $this->getData();
        $d = 0;
        foreach ($input as $data) {
            foreach ($data['output'] as $value) {
                if ($this->countValueToNumber($value) > 0) {
                    $d++;
                }
            }
        }

        $this->info(
            'In the output values, how many times do digits 1, 4, 7, or 8 appear?',
        );
        $this->line($d);
    }

    public function two(): void
    {
        $input = $this->getData();
        $d = 0;

        foreach ($input as $data) {
            $numbers = $this->determineNumbers($data['numbers']);
            $displayNumber = '';
            foreach ($data['output'] as $output) {
                $displayNumber .= $this->getNumber($numbers, $output);
            }
            $d += (int) $displayNumber;
        }

        $this->info(
            'For each entry, determine all of the wire/segment connections and decode the four-digit output values. What do you get if you add up all of the output values?',
        );
        $this->line($d);
    }

    protected function countValueToNumber(array $input): ?int
    {
        return match (count($input)) {
            2 => 1,
            3 => 7,
            4 => 4,
            7 => 8,
            default => null
        };
    }

    protected function getNumber(array $numbers, array $data): int
    {
        foreach ($numbers as $number => $value) {
            $d = count(array_intersect($value, $data));
            if ($d === count($data) && $d === count($value)) {
                return $number;
            }
        }
    }

    #[Pure]
    protected function determineNumbers(array $data): array
    {
        $numbers = [];
        foreach ($data as $value) {
            if ($number = $this->countValueToNumber($value)) {
                $numbers[$number] = $value;
            }
        }

        // calculate 9
        $d = array_diff($numbers[8], [...$numbers[4], ...$numbers[7]]);
        foreach ($data as $value) {
            if (count($value) === 6) {
                $x = array_diff($value, [...$numbers[4], ...$numbers[7]]);
                if (count(array_intersect($x, $d)) === 1) {
                    $numbers[9] = $value;
                }
            }
        }

        // calculate 0, 6
        foreach ($data as $value) {
            if (count($value) === 6) {
                if (array_diff($value, $numbers[9]) !== []) {
                    if (count(array_diff($value, $numbers[7])) === 3) {
                        $numbers[0] = $value;
                    }

                    if (count(array_diff($value, $numbers[7])) === 4) {
                        $numbers[6] = $value;
                    }
                }
            }
        }

        // calculate 3
        foreach ($data as $value) {
            if (count($value) === 5) {
                if (count(array_diff($value, $numbers[1])) === 3) {
                    $numbers[3] = $value;
                }
            }
        }

        // calculate 2, 5
        foreach ($data as $value) {
            if (count($value) === 5) {
                if (array_diff($value, $numbers[3]) !== []) {
                    if (count(array_diff($value, $numbers[6])) === 0) {
                        $numbers[5] = $value;
                    }

                    if (count(array_diff($value, $numbers[6])) === 1) {
                        $numbers[2] = $value;
                    }
                }
            }
        }

        return $numbers;
    }

    protected function getData(): array
    {
        $data = [];
        foreach ($this->input as $item) {
            [$inputNumbers, $outputNumbers] = explode(' | ', $item);
            $data[] = [
                'numbers' => array_map(
                    static fn ($x) => str_split($x),
                    explode(' ', $inputNumbers),
                ),
                'output' => array_map(
                    static fn ($x) => str_split($x),
                    explode(' ', $outputNumbers),
                ),
            ];
        }

        return $data;
    }
}

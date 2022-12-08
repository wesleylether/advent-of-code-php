<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;
use JetBrains\PhpStorm\ArrayShape;

class Day4 extends BaseAdventOfCodeDay
{
    #[ArrayShape(['part1' => 'int[]', 'part2' => 'int[]'])]
    public function getResult(): array
    {
        $passports = [];
        $passport = [];
        foreach ($this->input as $data) {
            if ($data === '') {
                $passports[] = $passport;
                $passport = [];

                continue;
            }

            foreach (\explode(' ', $data) as $part) {
                [$name, $value] = \explode(':', $part);
                $passport[$name] = $value;
            }
        }
        if (count($passport)) {
            $passports[] = $passport;
        }

        $neededKeys = ['byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid'];

        $result = [
            'part1' => [
                'valid' => 0,
                'invalid' => 0,
            ],
            'part2' => [
                'valid' => 0,
                'invalid' => 0,
            ],
        ];

        foreach ($passports as $passport) {
            $intersect = \array_intersect(\array_keys($passport), $neededKeys);
            if (count($intersect) === count($neededKeys)) {
                $result['part1']['valid']++;

                $validated = \array_combine(
                    $neededKeys,
                    \array_fill(0, count($neededKeys), 0),
                );
                foreach ($passport as $name => $value) {
                    switch ($name) {
                        case 'byr':
                            $value = (int) $value;
                            if ($value >= 1920 && $value <= 2002) {
                                $validated[$name] = 1;
                            }
                            break;
                        case 'iyr':
                            $value = (int) $value;
                            if ($value >= 2010 && $value <= 2020) {
                                $validated[$name] = 1;
                            }
                            break;
                        case 'eyr':
                            $value = (int) $value;
                            if ($value >= 2020 && $value <= 2030) {
                                $validated[$name] = 1;
                            }
                            break;
                        case 'hgt':
                            if (
                                \preg_match('/(\d+)(cm|in)$/', $value, $matches)
                            ) {
                                $height = (int) $matches[1];
                                switch ($matches[2]) {
                                    case 'cm':
                                        if ($height >= 150 && $height <= 193) {
                                            $validated[$name] = 1;
                                        }
                                        break;
                                    case 'in':
                                        if ($height >= 59 && $height <= 76) {
                                            $validated[$name] = 1;
                                        }
                                        break;
                                }
                            }
                            break;
                        case 'hcl':
                            if (\preg_match('/^#[0-9a-f]{6}$/', $value)) {
                                $validated[$name] = 1;
                            }
                            break;
                        case 'ecl':
                            if (
                                \in_array($value, [
                                    'amb',
                                    'blu',
                                    'brn',
                                    'gry',
                                    'grn',
                                    'hzl',
                                    'oth',
                                ])
                            ) {
                                $validated[$name] = 1;
                            }
                            break;
                        case 'pid':
                            if (\preg_match('/^\d{9}$/', $value)) {
                                $validated[$name] = 1;
                            }
                            break;
                    }
                }

                if (\array_sum($validated) === count($neededKeys)) {
                    $result['part2']['valid']++;
                } else {
                    $result['part2']['invalid']++;
                }
            } else {
                $result['part1']['invalid']++;
            }
        }

        return $result;
    }

    public function one(): void
    {
        $result = $this->getResult();
        $this->line(sprintf('Valid: %s', $result['part1']['valid']));
        $this->line(sprintf('Invalid: %s', $result['part1']['invalid']));
    }

    public function two(): void
    {
        $result = $this->getResult();
        $this->line(sprintf('Valid: %s', $result['part2']['valid']));
        $this->line(sprintf('Invalid: %s', $result['part2']['invalid']));
    }
}

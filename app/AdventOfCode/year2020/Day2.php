<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;

class Day2 extends BaseAdventOfCodeDay
{
    protected array $result = [
        'part1' => [
            'right' => 0,
            'wrong' => 0,
        ],
        'part2' => [
            'right' => 0,
            'wrong' => 0,
        ],
    ];

    public function one(): void
    {
        foreach ($this->input as $validator) {
            preg_match(
                '/^(\d+)-(\d+)\s([a-z]):\s(\w+)$/',
                $validator,
                $matches,
            );
            $min = $matches[1];
            $max = $matches[2];
            $letter = $matches[3];
            $password = $matches[4];

            // part 1
            $count = substr_count($password, $letter);
            if ($count >= $min && $count <= $max) {
                $this->result['part1']['right']++;
            } else {
                $this->result['part1']['wrong']++;
            }
        }

        $this->line(sprintf('right: %s', $this->result['part1']['right']));
        $this->line(sprintf('wrong: %s', $this->result['part1']['wrong']));
    }

    public function two(): void
    {
        foreach ($this->input as $validator) {
            preg_match(
                '/^(\d+)-(\d+)\s([a-z]):\s(\w+)$/',
                $validator,
                $matches,
            );
            $min = $matches[1];
            $max = $matches[2];
            $letter = $matches[3];
            $password = $matches[4];

            // part 1
            $count = substr_count($password, $letter);
            if ($count >= $min && $count <= $max) {
                $this->result['part1']['right']++;
            } else {
                $this->result['part1']['wrong']++;
            }

            // part 2
            $first = substr($password, $min - 1, 1);
            $second = substr($password, $max - 1, 1);

            if ($first === $letter && $second !== $letter) {
                $this->result['part2']['right']++;
            } else {
                if ($second === $letter && $first !== $letter) {
                    $this->result['part2']['right']++;
                } else {
                    $this->result['part2']['wrong']++;
                }
            }
        }

        $this->line(sprintf('right: %s', $this->result['part2']['right']));
        $this->line(sprintf('wrong: %s', $this->result['part2']['wrong']));
    }
}

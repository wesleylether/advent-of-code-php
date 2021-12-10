<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function array_map;
use function array_pop;
use function array_reduce;
use function array_reverse;
use function count;
use function key;
use function last;
use function str_split;

final class Day10 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $lookup = [
            ')' => 3,
            ']' => 57,
            '}' => 1197,
            '>' => 25137,
        ];

        $count = 0;
        [$corrupted] = $this->getData();
        foreach ($corrupted as $data) {
            $count += $lookup[key($data)];
        }

        $this->info(
            'Find the first illegal character in each corrupted line of the navigation subsystem. What is the total syntax error score for those errors?',
        );
        $this->line($count);
    }

    public function two(): void
    {
        $lookup = [
            ')' => 1,
            ']' => 2,
            '}' => 3,
            '>' => 4,
        ];
        [, $incomplete] = $this->getData();

        $scores = [];
        foreach ($incomplete as $line) {
            $missing = array_map(static function ($item) {
                return match ($item) {
                    '(' => ')',
                    '[' => ']',
                    '{' => '}',
                    '<' => '>'
                };
            }, array_reverse($line));

            $score = array_reduce(
                $missing,
                static fn($carry, $item) => $carry * 5 + $lookup[$item],
                0,
            );
            $scores[] = $score;
        }
        sort($scores);
        $this->info(
            'Find the completion string for each incomplete line, score the completion strings, and sort the scores. What is the middle score?',
        );
        $this->line($scores[floor(count($scores) * 0.5)]);
    }

    protected function getData(): array
    {
        $corrupted = [];
        $incomplete = [];
        foreach ($this->input as $line) {
            $data = [];
            foreach (str_split($line) as $char) {
                switch ($char) {
                    case '(':
                    case '{':
                    case '[':
                    case '<':
                        $data[] = $char;
                        continue 2;
                    case ')':
                        if (last($data) === '(') {
                            array_pop($data);
                            continue 2;
                        }
                        break;
                    case '}':
                        if (last($data) === '{') {
                            array_pop($data);
                            continue 2;
                        }
                        break;
                    case ']':
                        if (last($data) === '[') {
                            array_pop($data);
                            continue 2;
                        }
                        break;
                    case '>':
                        if (last($data) === '<') {
                            array_pop($data);
                            continue 2;
                        }
                        break;
                }

                $corrupted[] = [$char => $line];
                continue 2;
            }

            $incomplete[] = $data;
        }

        return [$corrupted, $incomplete];
    }
}

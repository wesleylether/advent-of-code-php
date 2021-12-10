<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function array_map;
use function array_pop;
use function array_reduce;
use function array_reverse;
use function count;
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
        $corrupted = 0;

        foreach ($this->input as $line) {
            $data = [];
            foreach (str_split($line) as $i => $char) {
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

                $count += $lookup[$char];
                $corrupted++;
                continue 2;
            }
        }

        $this->info(
            'Find the first illegal character in each corrupted line of the navigation subsystem. What is the total syntax error score for those errors?',
        );
        $this->warn("Corrupted: $corrupted");
        $this->line($count);
    }

    public function two(): void
    {
        $incomplete = [];
        foreach ($this->input as $line) {
            $data = [];
            foreach (str_split($line) as $i => $char) {
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
                continue 2;
            }

            $incomplete[] = $data;
        }

        $lookup = [
            ')' => 1,
            ']' => 2,
            '}' => 3,
            '>' => 4,
        ];

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
}

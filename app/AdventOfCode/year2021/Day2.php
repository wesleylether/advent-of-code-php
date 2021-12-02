<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021;

final class Day2 extends \App\AdventOfCode\BaseAdventOfCodeDay
{
    public function one(): void
    {
        $position = [
            'horizontal' => 0,
            'depth' => 0,
        ];

        foreach ($this->inputGenerator() as [$direction, $amount]) {
            switch ($direction) {
                case 'forward':
                    $position['horizontal'] += $amount;
                    break;
                case 'down':
                    $position['depth'] += $amount;
                    break;
                case 'up':
                    $position['depth'] -= $amount;
                    break;
            }
        }

        $this->info(
            'Calculate the horizontal position and depth you would have after following the planned course. What do you get if you multiply your final horizontal position by your final depth?',
        );
        $this->line($position['horizontal'] * $position['depth']);
    }

    public function two(): void
    {
        $position = [
            'horizontal' => 0,
            'depth' => 0,
            'aim' => 0,
        ];

        foreach ($this->inputGenerator() as [$direction, $amount]) {
            switch ($direction) {
                case 'forward':
                    $position['horizontal'] += $amount;

                    $position['depth'] += $amount * $position['aim'];
                    break;
                case 'down':
                    $position['aim'] += $amount;
                    break;
                case 'up':
                    $position['aim'] -= $amount;
                    break;
            }
        }

        $this->info(
            'Using this new interpretation of the commands, calculate the horizontal position and depth you would have after following the planned course. What do you get if you multiply your final horizontal position by your final depth?',
        );
        $this->line($position['horizontal'] * $position['depth']);
    }

    protected function inputGenerator(): \Generator
    {
        foreach ($this->input as $input) {
            \preg_match('/^(\w+) (\d)$/', $input, $matches);
            [, $direction, $amount] = $matches;

            yield [$direction, $amount];
        }
    }
}

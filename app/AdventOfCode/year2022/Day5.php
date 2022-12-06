<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2022;

use App\AdventOfCode\BaseAdventOfCodeDay;

final class Day5 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        // create part 1
        $stacks = $this->getStacks();
        foreach ($this->getInstructions() as [$count, $from, $to]) {
            foreach (range(1, $count) as $index) {
                $stacks[$to][] = array_pop($stacks[$from]);
            }
        }

        $ends = '';
        foreach ($stacks as $stack) {
            $ends .= end($stack);
        }

        $this->info('After the rearrangement procedure completes, what crate ends up on top of each stack?');
        $this->line($ends);
    }

    public function two(): void
    {
        // create part 2
        $stacks = $this->getStacks();
        foreach ($this->getInstructions() as [$count, $from, $to]) {
            $boxes = [];
            foreach (range(1, $count) as $index) {

                $boxes[] = array_pop($stacks[$from]);
            }
            $stacks[$to] = [...$stacks[$to], ...array_reverse($boxes)];
        }

        $ends = '';
        foreach ($stacks as $stack) {
            $ends .= end($stack);
        }

        $this->info('After the rearrangement procedure completes, what crate ends up on top of each stack?');
        $this->line($ends);

    }

    protected function getStacks(): array
    {
        $stacks = [
            1 => [],
            2 => [],
            3 => [],
            4 => [],
            5 => [],
            6 => [],
            7 => [],
            8 => [],
            9 => [],
        ];

       foreach(array_slice($this->input, 0, 8) as $layer) {
           foreach (range(1, 9) as $index) {
               $box = $layer[($index * 4 - 2) - 1];
               if (!empty(trim($box))) {
                   array_unshift($stacks[$index], $box);
               }
           }
       }

       return $stacks;
    }

    protected function getInstructions(): \Generator
    {
        foreach (array_slice($this->input, 10) as $instruction) {
            preg_match('/move (\d+) from (\d+) to (\d+)/', $instruction, $matches);
            [,$count, $from, $to] = $matches;
            yield [(int)$count, (int)$from, (int)$to];
        }
    }
}

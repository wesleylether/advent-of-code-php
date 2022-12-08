<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function array_shift;
use function ctype_lower;
use function explode;
use function in_array;

final class Day12 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $this->info(
            'How many paths through this cave system are there that visit small caves at most once?',
        );
        $this->line($this->runRoutes());
    }

    public function two(): void
    {
        $this->info(
            'Given these new rules, how many paths through this cave system are there?',
        );
        $this->line($this->runRoutes(true));
    }

    protected function getData(): array
    {
        $data = [];
        foreach ($this->input as $item) {
            [$a, $b] = explode('-', $item);
            $data[$a][] = $b;
            $data[$b][] = $a;
        }

        return $data;
    }

    protected function runRoutes(bool $smallTwice = false): int
    {
        $data = $this->getData();
        $count = 0;

        $queue = [['start', ['start'], false]];
        while ($queue) {
            [$direction, $visited, $twice] = array_shift($queue);
            if ($direction === 'end') {
                $count++;

                continue;
            }
            foreach ($data[$direction] as $d) {
                if (! in_array($d, $visited, true)) {
                    $newVisited = $visited;
                    if (ctype_lower($d)) {
                        $newVisited[] = $d;
                    }
                    $queue[] = [$d, $newVisited, $twice];
                } elseif (
                    $smallTwice &&
                    $twice === false &&
                    ! in_array($d, ['start', 'end'], true)
                ) {
                    $queue[] = [$d, $visited, $d];
                }
            }
        }

        return $count;
    }
}

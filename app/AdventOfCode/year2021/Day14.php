<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function array_count_values;
use function array_key_exists;
use function implode;
use function max;
use function min;
use function preg_match;
use function str_split;

final class Day14 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        [$polymer, $pairs] = $this->getData();

        $step = 0;
        while (++$step <= 10) {
            $polymer = $this->process($polymer, $pairs);
        }

        $counts = array_count_values($polymer);

        $this->info(
            'What do you get if you take the quantity of the most common element and subtract the quantity of the least common element?',
        );
        $this->line(max($counts) - min($counts));
    }

    public function two(): void
    {
        [$polymer, $pairs] = $this->getData();

        $polyPairs = [];
        foreach (range(0, count($polymer) - 1) as $i) {
            if (isset($polymer[$i + 1])) {
                $group = implode([$polymer[$i], $polymer[$i + 1]]);
                if (isset($polyPairs[$group])) {
                    ++$polyPairs[$group];
                } else {
                    $polyPairs[$group] = 1;
                }
            }
        }

        $step = 0;
        while (++$step <= 40) {
            $tempPolyParis = [];
            foreach ($polyPairs as $polyPair => $count) {
                $groupA = $polyPair[0] . $pairs[$polyPair];
                if (isset($tempPolyParis[$groupA])) {
                    $tempPolyParis[$groupA] += $count;
                } else {
                    $tempPolyParis[$groupA] = $count;
                }

                $groupB = $pairs[$polyPair] . $polyPair[1];
                if (isset($tempPolyParis[$groupB])) {
                    $tempPolyParis[$groupB] += $count;
                } else {
                    $tempPolyParis[$groupB] = $count;
                }
            }

            $polyPairs = $tempPolyParis;
        }

        $counter = [];
        foreach ($polyPairs as $polyPair => $count) {
            if (isset($counter[$polyPair[0]])) {
                $counter[$polyPair[0]] += $count;
            } else {
                $counter[$polyPair[0]] = $count;
            }
        }
        ++$counter[$polymer[count($polymer) - 1]];

        $this->info(
            'Apply 40 steps of pair insertion to the polymer template and find the most and least common elements in the result. What do you get if you take the quantity of the most common element and subtract the quantity of the least common element?',
        );
        $this->line(max($counter) - min($counter));
    }

    protected function process(array $polymer, array $pairs): array
    {
        $delta = [];
        foreach ($polymer as $i => $m) {
            if (isset($polymer[$i + 1])) {
                $match = implode([$m, $polymer[$i + 1]]);
                if (array_key_exists($match, $pairs)) {
                    $delta[] = $m;
                    $delta[] = $pairs[$match];
                }
            } else {
                $delta[] = $m;
            }
        }
        return $delta;
    }

    protected function getData(): array
    {
        $polymer = [];
        $pairs = [];
        foreach ($this->input as $item) {
            if (preg_match('/^[A-Z]+$/', $item, $matches)) {
                $polymer = str_split($matches[0]);
            }

            if (preg_match('/^([A-Z]{2}) -> ([A-Z])$/', $item, $matches)) {
                $pairs[$matches[1]] = $matches[2];
            }
        }

        return [$polymer, $pairs];
    }
}

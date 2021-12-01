<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;

class Day13 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $timeStamp = (int) $this->input[0];
        \preg_match_all('/(\d)+/', $this->input[1], $matches);
        $busses = \array_map(static fn($bus) => (int) $bus, $matches[0]);

        $busMap = \array_map(
            static fn($busId) => $busId - ($timeStamp % $busId),
            \array_combine($busses, $busses),
        );

        $min = min($busMap);
        $busId = \array_search($min, $busMap, true);

        $this->info(
            'What is the ID of the earliest bus you can take to the airport multiplied by the number of minutes you\'ll need to wait for that bus?',
        );
        $this->line($busId * $min);
    }

    public function two(): void
    {
        $busses = \explode(',', $this->input[1]);
        $timestamp = 0;
        $add = 1;
        $step = 0;

        while (true) {
            if ($busses[$step] === 'x') {
                $step++;
                continue;
            }
            if (($timestamp + $step) % $busses[$step] === 0) {
                $add *= $busses[$step];
                $step++;
            }
            if ($step === count($busses)) {
                break;
            }
            $timestamp += $add;
        }

        $this->info(
            'What is the earliest timestamp such that all of the listed bus IDs depart at offsets matching their positions in the list?',
        );
        $this->line($timestamp);
    }
}

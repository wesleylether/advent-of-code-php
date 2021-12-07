<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2015;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function array_reduce;
use function count;
use function str_split;

final class Day3 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $directions = str_split($this->input[0]);
        $x = 0;
        $y = 0;
        $houses[$x][$y] = 1;

        foreach ($directions as $direction) {
            switch ($direction) {
                case '^':
                    $y++;
                    break;
                case '>':
                    $x++;
                    break;
                case 'v':
                    $y--;
                    break;
                case '<':
                    $x--;
                    break;
            }

            if (isset($houses[$x][$y])) {
                $houses[$x][$y]++;
            } else {
                $houses[$x][$y] = 1;
            }
        }

        $this->info('How many houses receive at least one present?');
        $housesWithPresents = array_reduce(
            $houses,
            static function ($carry, $current) {
                return $carry + count($current);
            },
            0,
        );
        $this->line($housesWithPresents);
    }

    public function two(): void
    {
        $directions = str_split($this->input[0]);
        $x1 = 0;
        $y1 = 0;
        $x2 = 0;
        $y2 = 0;
        $houses[0][0] = 2;

        foreach ($directions as $index => $direction) {
            if ($index % 2 === 0) {
                switch ($direction) {
                    case '^':
                        $y1++;
                        break;
                    case '>':
                        $x1++;
                        break;
                    case 'v':
                        $y1--;
                        break;
                    case '<':
                        $x1--;
                        break;
                }

                if (isset($houses[$x1][$y1])) {
                    $houses[$x1][$y1]++;
                } else {
                    $houses[$x1][$y1] = 1;
                }
            } else {
                switch ($direction) {
                    case '^':
                        $y2++;
                        break;
                    case '>':
                        $x2++;
                        break;
                    case 'v':
                        $y2--;
                        break;
                    case '<':
                        $x2--;
                        break;
                }

                if (isset($houses[$x2][$y2])) {
                    $houses[$x2][$y2]++;
                } else {
                    $houses[$x2][$y2] = 1;
                }
            }
        }

        $this->info('This year, how many houses receive at least one present?');
        $housesWithPresents = array_reduce(
            $houses,
            static function ($carry, $current) {
                return $carry + count($current);
            },
            0,
        );
        $this->line($housesWithPresents);
    }
}

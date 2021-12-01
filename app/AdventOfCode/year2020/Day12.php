<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;

class Day12 extends BaseAdventOfCodeDay
{
    private const NORTH = 'N';
    private const SOUTH = 'S';
    private const EAST = 'E';
    private const WEST = 'W';
    private const LEFT = 'L';
    private const RIGHT = 'R';
    private const FORWARD = 'F';

    public function one(): void
    {
        $horizontal = 0;
        $vertical = 0;
        $direction = 90;

        foreach ($this->input as $instruction) {
            \preg_match('/^(\w)(\d+)$/', $instruction, $matches);
            [, $type, $value] = $matches;

            switch ($type) {
                case self::NORTH:
                    $vertical -= $value;
                    break;
                case self::EAST:
                    $horizontal += $value;
                    break;
                case self::SOUTH:
                    $vertical += $value;
                    break;
                case self::WEST:
                    $horizontal -= $value;
                    break;
                case self::LEFT:
                    $direction -= $value;
                    if ($direction < 0) {
                        $direction += 360;
                    }
                    break;
                case self::RIGHT:
                    $direction += $value;
                    if ($direction >= 360) {
                        $direction -= 360;
                    }
                    break;
                case self::FORWARD:
                    switch ($direction) {
                        case 90:
                            $horizontal += $value;
                            break;
                        case 180:
                            $vertical += $value;
                            break;
                        case 270:
                            $horizontal -= $value;
                            break;
                        case 0:
                            $vertical -= $value;
                            break;
                    }
                    break;
            }
        }

        $this->info(
            'What is the Manhattan distance between that location and the ship\'s starting position? (part 1)',
        );
        $this->line(abs($horizontal) + abs($vertical));
    }

    public function two(): void
    {
        $waypoint = [
            'x' => 10,
            'y' => -1,
        ];
        $position = [
            'x' => 0,
            'y' => 0,
        ];

        foreach ($this->input as $instruction) {
            \preg_match('/^(\w)(\d+)$/', $instruction, $matches);
            [, $type, $value] = $matches;

            switch ($type) {
                case self::NORTH:
                    $waypoint['y'] -= $value;
                    break;
                case self::EAST:
                    $waypoint['x'] += $value;
                    break;
                case self::SOUTH:
                    $waypoint['y'] += $value;
                    break;
                case self::WEST:
                    $waypoint['x'] -= $value;
                    break;
                case self::LEFT:
                    do {
                        $waypoint = [
                            'x' => $waypoint['y'],
                            'y' => $waypoint['x'] * -1,
                        ];
                    } while ($value -= 90);
                    break;
                case self::RIGHT:
                    do {
                        $waypoint = [
                            'y' => $waypoint['x'],
                            'x' => $waypoint['y'] * -1,
                        ];
                    } while ($value -= 90);
                    break;
                case self::FORWARD:
                    $position['x'] += $waypoint['x'] * $value;
                    $position['y'] += $waypoint['y'] * $value;
                    break;
            }
        }

        $this->info(
            'What is the Manhattan distance between that location and the ship\'s starting position? (part 2)',
        );
        $this->line(abs($position['x']) + abs($position['y']));
    }
}

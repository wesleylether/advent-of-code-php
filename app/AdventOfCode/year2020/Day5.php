<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;

class Day5 extends BaseAdventOfCodeDay
{
    public function getBoardingPasses(): array
    {
        $boardingPasses = [];
        foreach ($this->input as $boardingPass) {
            \preg_match('/^([FB]{7})([LR]{3})/', $boardingPass, $matches);
            $rowBinary = \str_replace(['F', 'B'], ['0', '1'], $matches[1]);
            $row = \bindec($rowBinary);
            $columnBinary = \str_replace(['L', 'R'], ['0', '1'], $matches[2]);
            $column = \bindec($columnBinary);

            $boardingPasses[] = [
                'row' => $row,
                'column' => $column,
                'ID' => $row * 8 + $column,
            ];
        }
        return $boardingPasses;
    }

    protected function getHighestSeatID(): int
    {
        return \array_reduce(
            $this->getBoardingPasses(),
            static function ($carry, $item) {
                if ($item['ID'] > $carry) {
                    return $item['ID'];
                }

                return $carry;
            },
            0,
        );
    }

    public function one(): void
    {
        $this->info('Highest Seat ID:');
        $this->line($this->getHighestSeatID());
    }

    public function two(): void
    {
        $seats = \range(0, $this->getHighestSeatID());
        $seatsTaken = \array_map(static function ($boardingPass) {
            return $boardingPass['ID'];
        }, $this->getBoardingPasses());

        $availableSeats = \array_diff($seats, $seatsTaken);
        $frontSeatsRemoved = \array_filter(
            $availableSeats,
            static fn($seat) => $seat > 7 && $seat < 127 * 8,
        );
        $this->info('Available seat:');
        $this->line($frontSeatsRemoved);
    }
}

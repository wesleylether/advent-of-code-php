<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;
use Illuminate\Support\Facades\Log;

class Day11 extends BaseAdventOfCodeDay
{
    private const PART_ONE = 'part-one';

    private const PART_TWO = 'part-two';

    private const EMPTY_SEAT = 'L';

    private const TAKEN_SEAT = '#';

    private const FLOOR = '.';

    protected array $grid = [];

    public function one(): void
    {
        $this->info('How many seats end up occupied? (part 1)');
        $this->line($this->seatingSystem($this->getGrid(), self::PART_ONE));
    }

    public function two(): void
    {
        $this->info('How many seats end up occupied? (part 2)');
        $this->line($this->seatingSystem($this->getGrid(), self::PART_TWO));
    }

    public function getGrid(): array
    {
        $grid = [];
        foreach ($this->input as $index => $row) {
            $grid[$index] = \str_split($row);
        }

        return $grid;
    }

    protected function seatingSystem(array $grid, string $part): int
    {
        $this->grid = $grid;

        while ($this->grid !== ($new = $this->calculateSeating($part))) {
            echo '.';
            $this->grid = $new;
        }
        $this->newline();

        try {
            return \substr_count(
                \json_encode($this->grid, JSON_THROW_ON_ERROR),
                self::TAKEN_SEAT,
            );
        } catch (\JsonException $exception) {
            Log::error($exception->getMessage());
        }

        return 0;
    }

    protected function calculateSeating(string $part): array
    {
        $new = [];
        foreach ($this->grid as $rowIndex => $row) {
            foreach ($row as $seatIndex => $seat) {
                if ($seat === self::FLOOR) {
                    $new[$rowIndex][$seatIndex] = $seat;

                    continue;
                }

                $new[$rowIndex][$seatIndex] = match ($part) {
                    self::PART_ONE => $this->checkSeat(
                        $rowIndex,
                        $seatIndex,
                        $seat,
                    ),
                    self::PART_TWO => $this->checkVisibleSeat(
                        $rowIndex,
                        $seatIndex,
                        $seat,
                    )
                };
            }
        }

        return $new;
    }

    protected function checkSeat(int $row, int $seat, string $self): string
    {
        $aroundSeats = [
            'topLeft' => $this->grid[$row - 1][$seat - 1] ?? null,
            'topMiddle' => $this->grid[$row - 1][$seat] ?? null,
            'topRight' => $this->grid[$row - 1][$seat + 1] ?? null,
            'left' => $this->grid[$row][$seat - 1] ?? null,
            'right' => $this->grid[$row][$seat + 1] ?? null,
            'BottomLeft' => $this->grid[$row + 1][$seat - 1] ?? null,
            'BottomMiddle' => $this->grid[$row + 1][$seat] ?? null,
            'BottomRight' => $this->grid[$row + 1][$seat + 1] ?? null,
        ];

        if (
            $self === self::EMPTY_SEAT &&
            ! \in_array(self::TAKEN_SEAT, $aroundSeats, true)
        ) {
            return self::TAKEN_SEAT;
        }

        if (
            $self === self::TAKEN_SEAT &&
            \count(
                \array_filter(
                    $aroundSeats,
                    static fn ($seat) => $seat === self::TAKEN_SEAT,
                ),
            ) >= 4
        ) {
            return self::EMPTY_SEAT;
        }

        return $self;
    }

    protected function checkVisibleSeat(
        int $row,
        int $column,
        string $self,
    ): string {
        $count = 0;
        $seats = [
            [-1, -1],
            [-1, 0],
            [-1, 1],
            [0, -1],
            [0, 1],
            [1, -1],
            [1, 0],
            [1, 1],
        ];

        foreach ($seats as $seat) {
            $distance = 1;
            while (
                isset(
                    $this->grid[$row + $seat[0] * $distance][
                        $column + $seat[1] * $distance
                    ],
                )
            ) {
                if (
                    $this->grid[$row + $seat[0] * $distance][
                        $column + $seat[1] * $distance
                    ] === self::EMPTY_SEAT
                ) {
                    break;
                }
                if (
                    $this->grid[$row + $seat[0] * $distance][
                        $column + $seat[1] * $distance
                    ] === self::TAKEN_SEAT
                ) {
                    $count++;
                    break;
                }
                $distance++;
            }
        }

        if ($count === 0) {
            return self::TAKEN_SEAT;
        }

        if ($count > 4) {
            return self::EMPTY_SEAT;
        }

        return $self;
    }
}

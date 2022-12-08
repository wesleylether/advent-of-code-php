<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;

class Day14 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $memory = [];
        $mask = '';

        foreach ($this->input as $instruction) {
            if (str_starts_with($instruction, 'mask')) {
                $mask = \str_replace('mask = ', '', $instruction);

                continue;
            }

            \preg_match('/mem\[(\d+)] = (\d+)/', $instruction, $matches);
            [, $maskAddress, $value] = $matches;

            $memory[$maskAddress] = \bindec(
                $this->mask((int) $value, $mask, 'X'),
            );
        }

        $this->info(
            'What is the sum of all values left in memory after it completes? (part 1)',
        );
        $this->line(\array_sum($memory));
    }

    public function two(): void
    {
        $memory = [];
        $mask = '';

        foreach ($this->input as $instruction) {
            if (str_starts_with($instruction, 'mask')) {
                $mask = \str_replace('mask = ', '', $instruction);

                continue;
            }

            \preg_match('/mem\[(\d+)] = (\d+)/', $instruction, $matches);
            [, $memAddress, $value] = $matches;

            $maskedMemAddress = $this->mask((int) $memAddress, $mask, '0');
            foreach (
                $this->expandMaskedAddress($maskedMemAddress)
                as $memAddress
            ) {
                $memory[$memAddress] = $value;
            }
        }

        $this->info(
            'What is the sum of all values left in memory after it completes? (part 2)',
        );
        $this->line(\array_sum($memory));
    }

    protected function expandMaskedAddress(string $maskedMemAddress): \Generator
    {
        if (false === ($strPos = \strpos($maskedMemAddress, 'X'))) {
            yield \bindec($maskedMemAddress);

            return;
        }

        yield from $this->expandMaskedAddress(
            \substr_replace($maskedMemAddress, '1', $strPos, 1),
        );
        yield from $this->expandMaskedAddress(
            \substr_replace($maskedMemAddress, '0', $strPos, 1),
        );
    }

    protected function mask(int $number, string $mask, string $ignore): string
    {
        $number = \str_pad(\decbin($number), 36, '0', \STR_PAD_LEFT);
        foreach (
            \array_filter(
                \str_split($mask),
                static fn ($item) => $item !== $ignore,
            )
            as $key => $value
        ) {
            $number[$key] = $value;
        }

        return $number;
    }
}

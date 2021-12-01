<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\year2021\DTO\Year2021Day1DTO;

final class Day1 extends \App\AdventOfCode\BaseAdventOfCodeDay
{
    public function one(): void
    {
        $increases = 0;
        \array_reduce(
            $this->input,
            static function ($carry, $item) use (&$increases) {
                if ($carry > 0 && $item > $carry) {
                    $increases++;
                }

                return $item;
            },
            0,
        );

        $this->info(
            'How many measurements are larger than the previous measurement?',
        );
        $this->line($increases);
    }

    public function two(): void
    {
        $dto = new Year2021Day1DTO();
        $dto->input = $this->input;

        $result = \array_reduce(
            $this->input,
            static function (Year2021Day1DTO $dto, int $current) {
                if (
                    isset(
                        $dto->input[$dto->index],
                        $dto->input[$dto->index + 1],
                        $dto->input[$dto->index + 2],
                    )
                ) {
                    $sum = \array_sum([
                        $dto->input[$dto->index],
                        $dto->input[$dto->index + 1],
                        $dto->input[$dto->index + 2],
                    ]);
                    if ($dto->previous > 0 && $sum > $dto->previous) {
                        $dto->increases++;
                    }

                    $dto->previous = $sum;
                }

                $dto->index++;

                return $dto;
            },
            $dto,
        );

        $this->info(
            'Consider sums of a three-measurement sliding window. How many sums are larger than the previous sum?',
        );
        $this->line($result->increases);
    }
}

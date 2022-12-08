<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use App\AdventOfCode\year2021\Helpers\Day18\SnailNumber;
use function array_map;
use function array_reduce;
use JsonException;

final class Day18 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        /** @var SnailNumber $finalNumber */
        $finalNumber = array_reduce(
            $this->loadData(),
            /** @throws JsonException */
            static function (?SnailNumber $carry, SnailNumber $current) {
                if ($carry === null) {
                    return $current;
                }

                $newNumber = new SnailNumber("[$carry, $current]");
                $newNumber->reduce();

                return $newNumber;
            },
            null,
        );

        $this->info(
            'Add up all of the snailfish numbers from the homework assignment in the order they appear. What is the magnitude of the final sum?',
        );
        $this->line($finalNumber->magnitude());
    }

    /**
     * @throws JsonException
     */
    public function two(): void
    {
        $magnitude = 0;
        foreach ($this->loadData() as $n1) {
            foreach ($this->loadData() as $n2) {
                if ($n1 !== $n2) {
                    $number = new SnailNumber("[$n1,$n2]");
                    $number->reduce();
                    $magnitude = max($magnitude, $number->magnitude());
                }
            }
        }

        $this->info(
            'What is the largest magnitude of any sum of two different snailfish numbers from the homework assignment?',
        );
        $this->line($magnitude);
    }

    protected function loadData(): array
    {
        return array_map(
            /** @throws JsonException */
            static function (string $input) {
                return new SnailNumber($input);
            },
            $this->input,
        );
    }
}

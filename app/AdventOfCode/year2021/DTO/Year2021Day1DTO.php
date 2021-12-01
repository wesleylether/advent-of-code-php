<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021\DTO;

final class Year2021Day1DTO
{
    public function __construct(
        public array $input = [],
        public int $index = 0,
        public int $increases = 0,
        public int $previous = 0,
    ) {
    }
}

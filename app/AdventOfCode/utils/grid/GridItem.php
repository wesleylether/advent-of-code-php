<?php

declare(strict_types=1);

namespace App\AdventOfCode\utils\grid;

final class GridItem
{
    public function __construct(
        public readonly int $y,
        public readonly int $x,
        public string|int $value,
        public mixed $meta = null,
        public ?GridItem $topLeft = null,
        public ?GridItem $top = null,
        public ?GridItem $topRight = null,
        public ?GridItem $left = null,
        public ?GridItem $right = null,
        public ?GridItem $bottomLeft = null,
        public ?GridItem $bottom = null,
        public ?GridItem $bottomRight = null,
    ) {
    }
}

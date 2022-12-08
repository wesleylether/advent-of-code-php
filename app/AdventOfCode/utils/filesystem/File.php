<?php

declare(strict_types=1);

namespace App\AdventOfCode\utils\filesystem;

final class File
{
    public function __construct(
        public readonly string $name,
        public readonly int $size,
    ) {
    }

    public function __toString(): string
    {
        return "$this->name - $this->size";
    }
}

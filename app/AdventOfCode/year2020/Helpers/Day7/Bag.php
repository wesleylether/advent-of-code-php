<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2020\Helpers\Day7;

final class Bag
{
    public string $name;

    public array $contains = [];

    public array $containedBy = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function bagCount(): int
    {
        return 1 +
            \array_sum(
                \array_map(
                    static fn ($bag) => $bag['quantity'] *
                        $bag['bag']->bagCount(),
                    $this->contains,
                ),
            );
    }
}

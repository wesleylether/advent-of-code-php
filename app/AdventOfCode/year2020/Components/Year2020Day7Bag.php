<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2020\Components;

final class Year2020Day7Bag
{
    public string $name;
    public array $contains = [];
    public array $containedBy = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function bagCount()
    {
        return 1 +
            \array_sum(
                \array_map(
                    static fn($bag) => $bag['quantity'] *
                        $bag['bag']->bagCount(),
                    $this->contains,
                ),
            );
    }
}

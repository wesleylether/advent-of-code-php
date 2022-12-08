<?php

declare(strict_types=1);

if (! function_exists('numbers')) {
    function numbers(
        string|array $values,
        string|null $explodeSeparator = null,
    ): array {
        if (is_string($values)) {
            if ($explodeSeparator) {
                $values = explode($explodeSeparator, $values);
            } else {
                $values = str_split($values);
            }
        }

        return array_map(static fn ($x) => (int) $x, $values);
    }
}

if (! function_exists('grid')) {
    function grid(
        array $input,
        bool $numbers = true,
        string|null $explodeSeparator = null,
        bool $withValue = false,
        mixed $value = null,
    ): array {
        $grid = [];

        foreach ($input as $y => $line) {
            $items = $explodeSeparator
                ? explode($explodeSeparator, $line)
                : str_split($line);

            foreach ($items as $x => $item) {
                $delta = $numbers ? (int) $item : $item;
                if ($withValue) {
                    $grid[$y][$x] = [$delta => $value];
                } else {
                    $grid[$y][] = $delta;
                }
            }
        }

        return $grid;
    }
}

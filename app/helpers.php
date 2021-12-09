<?php
declare(strict_types=1);

if (!function_exists('numbers')) {
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

        return array_map(static fn($x) => (int) $x, $values);
    }
}

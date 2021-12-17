<?php
declare(strict_types=1);

namespace App\AdventOfCode\utils;

final class PQueue extends \SplPriorityQueue
{
    public const EXTR_BOTH = 3;
    public const EXTR_PRIORITY = 2;
    public const EXTR_DATA = 1;

    public function compare(mixed $priority1, mixed $priority2): int
    {
        return $priority2 <=> $priority1;
    }
}

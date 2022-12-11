<?php

declare(strict_types=1);

namespace App\AdventOfCode\utils\grid;

use Closure;

final class Grid
{
    public function __construct(
        public array $grid = []
    ) {
    }

    public static function fromRows(array $rows, bool $intValues = false, mixed $defaultMeta = null): self
    {
        $grid = new self();
        foreach ($rows as $yIndex => $row) {
            foreach (str_split($row) as $xIndex => $value) {
                $grid->grid[$yIndex][$xIndex] = new GridItem($yIndex, $xIndex, $intValues ? (int) $value : $value, $defaultMeta);
            }
        }

        return $grid;
    }

    public function setAdjacentGridItems(): void
    {
        foreach ($this->grid as $yIndex => $row) {
            foreach ($row as $xIndex => $gridItem) {
                foreach (['top' => -1, '' => 0, 'bottom' => 1] as $yName => $dy) {
                    foreach (['left' => -1, '' => 0, 'right' => 1] as $xName => $dx) {
                        $yy = $yIndex + $dy;
                        $xx = $xIndex + $dx;
                        if (isset($this->grid[$yy][$xx])) {
                            $methodName = [];
                            if (! empty($yName)) {
                                $methodName[] = $yName;
                            }
                            if (! empty($xName)) {
                                $methodName[] = $xName;
                            }

                            if (count($methodName) === 2) {
                                $methodName[1] = ucfirst($methodName[1]);
                            }

                            $gridItem->{implode('', $methodName)} = $this->grid[$yy][$xx];
                        }
                    }
                }
            }
        }
    }

    public function generatorAll(): \Generator
    {
        foreach ($this->grid as $row) {
            foreach ($row as $gridItem) {
                yield $gridItem;
            }
        }
    }

    public function traverseAll(Closure $closure): void
    {
        foreach ($this->grid as $row) {
            foreach ($row as $gridItem) {
                $closure($gridItem);
            }
        }
    }
}

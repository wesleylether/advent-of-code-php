<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2022;

use App\AdventOfCode\BaseAdventOfCodeDay;
use App\AdventOfCode\utils\grid\Grid;
use App\AdventOfCode\utils\grid\GridItem;

final class Day8 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $total = 0;
        $this->getGrid()->traverseAll(
            static function (GridItem $gridItem) use (&$total) {
                $isVisible = static function (GridItem $gridItem, string $direction) {
                    $adjacent = $gridItem->{$direction};
                    while ($adjacent) {
                        if ($adjacent->value >= $gridItem->value) {
                            return false;
                        }
                        $adjacent = $adjacent->{$direction};
                    }

                    return true;
                };

                if (
                    $isVisible($gridItem, 'top') ||
                    $isVisible($gridItem, 'right') ||
                    $isVisible($gridItem, 'bottom') ||
                    $isVisible($gridItem, 'left')
                ) {
                    $total++;
                }
            }
        );

        $this->info('Consider your map; how many trees are visible from outside the grid?');
        $this->line($total);
    }

    public function two(): void
    {
        $grid = $this->getGrid();
        $mostTrees = 0;
        $grid->traverseAll(
            static function (GridItem $gridItem) use (&$mostTrees) {
                $countSight = static function (GridItem $gridItem, string $direction) {
                    $count = 0;
                    $adjacent = $gridItem->{$direction};
                    while ($adjacent) {
                        if ($adjacent->value < $gridItem->value) {
                            $adjacent = $adjacent->{$direction};
                        } else {
                            $adjacent = null;
                        }
                        $count++;
                    }

                    return $count;
                };

                $top = $countSight($gridItem, 'top');
                $right = $countSight($gridItem, 'right');
                $bottom = $countSight($gridItem, 'bottom');
                $left = $countSight($gridItem, 'left');

                $total = $top * $right * $bottom * $left;
                if ($total > $mostTrees) {
                    $mostTrees = $total;
                }
            }
        );

        $this->info('Consider your map; how many trees are visible from outside the grid?');
        $this->line($mostTrees);
    }

    protected function getGrid(): Grid
    {
        $grid = Grid::fromRows($this->input, true, false);
        $grid->setAdjacentGridItems();

        return $grid;
    }
}

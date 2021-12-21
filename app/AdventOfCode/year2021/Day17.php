<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function preg_match;

final class Day17 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        [$xA, $xB, $yA, $yB] = $this->getTargetArea();

        $height = 0;
        $count = 0;
        foreach (range(0, 150) as $DX) {
            foreach (range(-200, 200) as $DY) {
                $targetReached = false;
                $maxY = 0;
                $x = 0;
                $y = 0;
                $dx = $DX;
                $dy = $DY;
                $try = 0;
                while (++$try <= 500) {
                    $x += $dx;
                    $y += $dy;
                    $maxY = max($maxY, $y);
                    if ($dx > 0) {
                        $dx--;
                    } elseif ($dx < 0) {
                        $dx++;
                    }
                    $dy--;
                    if ($xA <= $x && $x <= $xB && $yA <= $y && $y <= $yB) {
                        $targetReached = true;
                    }
                }

                if ($targetReached) {
                    $count++;
                    dump("X:$DX, Y:$DY, count:$count");

                    if ($maxY > $height) {
                        $height = $maxY;
                        dump("X:$DX, Y:$DY, maxH:$height");
                    }
                }
            }
        }

        $this->info(
            'What is the highest y position it reaches on this trajectory?',
        );
        $this->line($height);

        $this->info(
            'How many distinct initial velocity values cause the probe to be within the target area after any step?',
        );
        $this->line($count);
    }

    public function two(): void
    {
        // create part 2

        $this->one();
    }

    protected function getTargetArea(): array
    {
        preg_match(
            '/x=(-?\d+)\.\.(-?\d+), y=(-?\d+)\.\.(-?\d+)/',
            $this->input[0],
            $matches,
        );

        return [
            (int) $matches[1],
            (int) $matches[2],
            (int) $matches[3],
            (int) $matches[4],
        ];
    }
}

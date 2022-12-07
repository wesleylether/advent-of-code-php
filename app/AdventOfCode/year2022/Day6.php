<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2022;

use App\AdventOfCode\BaseAdventOfCodeDay;

final class Day6 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        // create part 1

        $this->info('How many characters need to be processed before the first start-of-packet marker is detected?');
        $this->line($this->getFirstUniqueMessage(4));
    }

    public function two(): void
    {
        // create part 2

        $this->info('question?');
        $this->line($this->getFirstUniqueMessage(14));
    }

    protected function getFirstUniqueMessage(int $size): int
    {
        $chars = str_split($this->input[0]);
        $index = 0;
        $found = false;
        while (!$found) {
            $markers = array_slice([...$chars], $index, $size);
            if (count(array_unique($markers)) === $size) {
                $found = true;
            } else {
                $index++;
            }
        }

        return $index + $size;
    }
}

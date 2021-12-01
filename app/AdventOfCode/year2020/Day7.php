<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;
use App\AdventOfCode\year2020\Components\Day7Bag;
use Illuminate\Support\Facades\Cache;

class Day7 extends BaseAdventOfCodeDay
{
    public function getData(): void
    {
        Cache::flush();
        foreach ($this->input as $line) {
            \preg_match('/^(.+)\sbags contain\s(.+)$/', $line, $matches);
            [, $name, $contents] = $matches;

            $bag = Cache::get($name, new Day7Bag($name));
            foreach (\explode(', ', $contents) as $content) {
                if (str_starts_with($content, 'no')) {
                    continue;
                }

                \preg_match('/^(\d+)\s(.+)\sbags?\.?$/', $content, $matchesBag);
                [, $contentCount, $contentName] = $matchesBag;

                $contentBag = Cache::get(
                    $contentName,
                    new Day7Bag($contentName),
                );
                $bag->contains[] = [
                    'quantity' => $contentCount,
                    'bag' => $contentBag,
                ];
                $contentBag->containedBy[] = $bag;
                Cache::put($contentName, $contentBag);
            }
            Cache::put($name, $bag);
        }
    }

    private function howManyBagsCanContainAShinyGoldBag(Day7Bag $bag): int
    {
        $containers = [];
        $candidates = $bag->containedBy;
        while ($candidate = \array_shift($candidates)) {
            $containers[] = $candidate->name;
            $candidates = \array_merge($candidates, $candidate->containedBy);
        }
        return count(\array_unique($containers));
    }

    public function one(): void
    {
        $this->getData();
        $shinyBag = Cache::get('shiny gold');

        $this->info(
            'How many bag colors can eventually contain at lest one shiny gold bag?',
        );
        $this->line($this->howManyBagsCanContainAShinyGoldBag($shinyBag));
    }

    public function two(): void
    {
        $this->getData();
        $shinyBag = Cache::get('shiny gold');

        $this->info(
            'How many individual bags are required inside your single shiny gold bag?',
        );
        $this->line($shinyBag->bagCount() - 1);
    }
}

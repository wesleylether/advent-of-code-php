<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;

class Day6 extends BaseAdventOfCodeDay
{
    public function getData(): array
    {
        $groupPersonAnswers = [];
        $personAnswers = [];
        foreach ($this->input as $data) {
            if ($data === '') {
                $groupPersonAnswers[] = $personAnswers;
                $personAnswers = [];
                continue;
            }

            $personAnswers[] = \str_split($data);
        }
        if (count($personAnswers)) {
            $groupPersonAnswers[] = $personAnswers;
        }

        $totalUniqueAnswers = [];
        $totalSameAnswers = [];
        foreach ($groupPersonAnswers as $personAnswer) {
            $totalUnique = [];
            $totalSame = $personAnswer[0];
            foreach ($personAnswer as $index => $answers) {
                $totalUnique = \array_unique(
                    \array_merge($totalUnique, $answers),
                );

                if ($index > 0) {
                    $totalSame = \array_intersect($totalSame, $answers);
                }
            }
            $totalUniqueAnswers[] = $totalUnique;
            $totalSameAnswers[] = $totalSame;
        }

        return [$totalUniqueAnswers, $totalSameAnswers];
    }

    public function one(): void
    {
        [$totalUniqueAnswers] = $this->getData();

        $countUnique = \array_reduce(
            $totalUniqueAnswers,
            static function ($carry, $item) {
                return $carry + count($item);
            },
            0,
        );

        $this->info('The sum of all group unique answer counts:');
        $this->line($countUnique);
    }

    public function two(): void
    {
        [, $totalSameAnswers] = $this->getData();
        $countSame = \array_reduce(
            $totalSameAnswers,
            static function ($carry, $item) {
                return $carry + count($item);
            },
            0,
        );

        $this->info('The sum of all group same answer counts:');
        $this->line($countSame);
    }
}

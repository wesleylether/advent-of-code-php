<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use App\AdventOfCode\year2021\Helpers\Day4\Bingo;
use function array_map;
use function array_pop;
use function array_shift;
use function explode;
use function preg_match;

final class Day4 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        [$numbers, $bingoCards] = $this->generateData();

        foreach ($numbers as $number) {
            foreach ($bingoCards as $bingoCard) {
                $bingoCard->addBingoNumber($number);
                if ($bingoCard->hasBingo()) {
                    $this->info(
                        'What will your final score be if you choose that board?',
                    );
                    $this->line($number * $bingoCard->getSumOfNotCalled());
                    return;
                }
            }
        }

        $this->line('no one has won');
    }

    public function two(): void
    {
        [$numbers, $bingoCards] = $this->generateData();
        $number = 0;

        while (count($bingoCards) > 1) {
            $number = array_shift($numbers);

            /**
             * @var int $index
             * @var Bingo $bingoCard
             */
            foreach ($bingoCards as $index => $bingoCard) {
                $bingoCard->addBingoNumber($number);
                if ($bingoCard->hasBingo()) {
                    unset($bingoCards[$index]);
                }
            }
        }

        /** @var Bingo $lastWinningBingoCard */
        $lastWinningBingoCard = array_pop($bingoCards);
        while (!$lastWinningBingoCard->hasBingo()) {
            $number = array_shift($numbers);
            $lastWinningBingoCard->addBingoNumber($number);
        }

        $this->info('What will your final score be if you choose that board?');
        $this->line($number * $lastWinningBingoCard->getSumOfNotCalled());
    }

    protected function generateData(): array
    {
        $numbers = [];
        $bingoCards = [];
        $bingo = new Bingo();
        foreach ($this->input as $index => $input) {
            if ($index === 0) {
                $numbers = array_map(
                    static fn($number) => (int) $number,
                    explode(',', $input),
                );

                continue;
            }

            if ($input === '') {
                if ($index !== 1) {
                    $bingoCards[] = $bingo;
                    $bingo = new Bingo();
                }
                continue;
            }

            preg_match('/^(..)\s(..)\s(..)\s(..)\s(..)$/', $input, $matches);
            [, $one, $two, $three, $four, $five] = $matches;
            $bingo->rows[] = [
                (int) $one => false,
                (int) $two => false,
                (int) $three => false,
                (int) $four => false,
                (int) $five => false,
            ];
        }

        return [$numbers, $bingoCards];
    }
}

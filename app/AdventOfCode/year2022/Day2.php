<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2022;

use App\AdventOfCode\BaseAdventOfCodeDay;

final class Day2 extends BaseAdventOfCodeDay
{
    private const OPPONENT_ROCK = 'A';
    private const OPPONENT_PAPER = 'B';
    private const OPPONENT_SCISSORS = 'C';

    private const ROCK = 'X';
    private const PAPER = 'Y';
    private const SCISSORS = 'Z';

    private const ROCK_POINT = 1;
    private const PAPER_POINT = 2;
    private const SCISSORS_POINT = 3;

    private const WIN = 6;
    private const DRAW = 3;
    private const LOSE = 0;

    public function one(): void
    {
        $score = 0;
        foreach ($this->input as $game) {
            preg_match('/(.)\s(.)/', $game, $matches);
            [, $opponent, $me] = $matches;

            switch($me) {
                case self::ROCK:
                    match($opponent) {
                        self::OPPONENT_ROCK => $score += self::DRAW,
                        self::OPPONENT_PAPER => $score += self::LOSE,
                        self::OPPONENT_SCISSORS => $score += self::WIN,
                    };
                    $score += self::ROCK_POINT;
                    break;
                case self::PAPER:
                    match($opponent) {
                        self::OPPONENT_ROCK => $score += self::WIN,
                        self::OPPONENT_PAPER => $score += self::DRAW,
                        self::OPPONENT_SCISSORS => $score += self::LOSE,
                    };
                    $score += self::PAPER_POINT;
                    break;
                case self::SCISSORS:
                    match($opponent) {
                        self::OPPONENT_ROCK => $score += self::LOSE,
                        self::OPPONENT_PAPER => $score += self::WIN,
                        self::OPPONENT_SCISSORS => $score += self::DRAW,
                    };
                    $score += self::SCISSORS_POINT;
                    break;
            }
        }

        $this->info('What would your total score be if everything goes exactly according to your strategy guide?');
        $this->line($score);
    }

    public function two(): void
    {
        $score = 0;
        foreach ($this->input as $game) {
            preg_match('/(.)\s(.)/', $game, $matches);
            [, $opponent, $outcome] = $matches;

            switch ($outcome) {
                case 'X': // lose
                    match($opponent) {
                        self::OPPONENT_ROCK => $score += self::SCISSORS_POINT,
                        self::OPPONENT_PAPER => $score += self::ROCK_POINT,
                        self::OPPONENT_SCISSORS => $score += self::PAPER_POINT,
                    };
                    $score += self::LOSE;
                    break;
                case 'Y': // draw
                    match($opponent) {
                        self::OPPONENT_ROCK => $score += self::ROCK_POINT,
                        self::OPPONENT_PAPER => $score += self::PAPER_POINT,
                        self::OPPONENT_SCISSORS => $score += self::SCISSORS_POINT,
                    };
                    $score += self::DRAW;
                    break;
                case 'Z': // win
                    match($opponent) {
                        self::OPPONENT_ROCK => $score += self::PAPER_POINT,
                        self::OPPONENT_PAPER => $score += self::SCISSORS_POINT,
                        self::OPPONENT_SCISSORS => $score += self::ROCK_POINT,
                    };
                    $score += self::WIN;
                    break;
            }
        }

        $this->info('Following the Elf\'s instructions for the second column, what would your total score be if everything goes exactly according to your strategy guide?');
        $this->line($score);
    }


}

<?php

namespace App\Console\Commands;

use App\AdventOfCode\BaseAdventOfCodeDay;
use Illuminate\Console\Command;

class AdventOfCodeCommand extends Command
{
    protected $signature = 'advent:of:code {year : Year of advent} {day : Day of advent year} {--one : Run part 1} {--two : Run part 2} {--example : Run with example file if exists}';
    protected $description = 'Run results of Advent of Code';

    private $time;

    public function handle()
    {
        $year = $this->argument('year');
        $day = $this->argument('day');
        $one = $this->option('one');
        $two = $this->option('two');

        $this->alert("Advent of code solution: $year-$day");

        $adventOfCodeClass = "App\AdventOfCode\year$year\Day$day";
        $filePath = "$year/$day/input";
        if (\class_exists($adventOfCodeClass)) {
            /** @var BaseAdventOfCodeDay $solution */
            $solution = new $adventOfCodeClass($this, $filePath);

            if (!$one && !$two) {
                $this->info('Part 1:');
                $this->start();
                $solution->one();
                $this->stop();

                $this->newLine();

                $this->info('Part 2:');
                $this->start();
                $solution->two();
                $this->stop();
            } elseif ($one) {
                $this->info('Part 1:');
                $this->start();
                $solution->one();
                $this->stop();
            } elseif ($two) {
                $this->info('Part 2:');
                $this->start();
                $solution->two();
                $this->stop();
            }
        } else {
            $this->error('Class does not exists:');
            $this->line($adventOfCodeClass);
        }
    }

    protected function start(): void
    {
        $this->time = \microtime(true);
    }

    protected function stop(): void
    {
        $end = \microtime(true);
        $executionTime = ($end - $this->time) * 1000;
        $executionTime = \number_format($executionTime, 2, ',', '.');
        $this->line("Time {$executionTime}ms");
    }
}

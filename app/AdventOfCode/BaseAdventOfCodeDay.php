<?php
declare(strict_types=1);

namespace App\AdventOfCode;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

abstract class BaseAdventOfCodeDay
{
    protected Command $command;
    protected array $input;

    public function __construct(Command $command, string $inputFile)
    {
        $this->command = $command;
        $file = Storage::get($inputFile);
        $this->input = \explode("\n", \rtrim($file));
    }

    public function newline(int $lines = 1): void
    {
        $this->command->newline($lines);
    }

    public function line($text): void
    {
        $this->command->line($text);
    }

    public function info($text): void
    {
        $this->command->info($text);
    }

    public function error($text): void
    {
        $this->command->error($text);
    }

    public function warn($text): void
    {
        $this->command->warn($text);
    }

    abstract public function one(): void;
    abstract public function two(): void;
}

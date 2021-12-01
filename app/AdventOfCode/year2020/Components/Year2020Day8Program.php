<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2020\Components;

final class Year2020Day8Program
{
    public int $index = 0;
    public int $accumulator = 0;
    public array $instructions;
    public array $seen = [];
    public bool $isInfinite = false;

    public function __construct(array $instructions)
    {
        $this->instructions = $instructions;
    }

    public function run()
    {
        while (true) {
            if (\in_array($this->index, \array_keys($this->seen))) {
                $this->isInfinite = true;
                break;
            }

            if ($this->eof()) {
                break;
            }

            $this->seen[$this->index] = true;
            /** @var Year2020Day8Instruction $instruction */
            $instruction = $this->instructions[$this->index];
            $instruction($this);
        }
    }

    private function eof(): bool
    {
        return $this->index >= count($this->instructions);
    }
}

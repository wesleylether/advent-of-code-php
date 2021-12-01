<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2020\Components;

final class Year2020Day8Instruction
{
    private const ACC = 'acc';
    private const JMP = 'jmp';
    private const NOP = 'nop';
    public string $type;
    public int $value;

    public function __construct(string $type, int $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public function __invoke(Year2020Day8Program $program)
    {
        switch ($this->type) {
            case self::ACC:
                $program->accumulator += $this->value;
                ++$program->index;
                break;
            case self::JMP:
                $program->index += $this->value;
                break;
            case self::NOP:
                ++$program->index;
                break;
        }
    }
}

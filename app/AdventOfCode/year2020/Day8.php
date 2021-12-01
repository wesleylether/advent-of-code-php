<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2020;

use App\AdventOfCode\BaseAdventOfCodeDay;
use App\AdventOfCode\year2020\Components\Day8Instruction;
use App\AdventOfCode\year2020\Components\Day8Program;
use Illuminate\Support\Facades\Cache;

class Day8 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $this->info(
            'Run your copy of the boot code. Immediately before any instruction is executed a second time, what value is in the accumulator?',
        );
        $this->line($this->getAccumulator());
    }

    public function two(): void
    {
        $this->info(
            'Fix the program so that it terminates normally by changing exactly one jmp (to nop) or nop (to jmp). What is the value of the accumulator after the program terminates?',
        );
        $this->line($this->getFixedProgramAccumulator());
    }

    public function getInstructions(): array
    {
        $instructions = [];
        foreach ($this->input as $line) {
            \preg_match('/^(\w{3})\s([-+]\d+)/', $line, $matches);
            [, $type, $value] = $matches;
            $instructions[] = new Day8Instruction($type, (int) $value);
        }
        return $instructions;
    }

    private function getAccumulator(): int
    {
        $program = new Day8Program($this->getInstructions());
        $program->run();

        return $program->accumulator;
    }

    private function getFixedProgramAccumulator(): ?int
    {
        foreach ($this->getInstructions() as $index => $instruction) {
            $instructions = $this->getInstructions();
            /** @var Day8Instruction $instructionToCheck */
            $instructionToCheck = $instructions[$index];
            if ($instructionToCheck->type === 'nop') {
                $instructions[$index] = new Day8Instruction(
                    'jmp',
                    $instructionToCheck->value,
                );
            } elseif ($instructionToCheck->type === 'jmp') {
                $instructions[$index] = new Day8Instruction(
                    'nop',
                    $instructionToCheck->value,
                );
            } else {
                continue;
            }

            $program = new Day8Program($instructions);
            $program->run();

            if (!$program->isInfinite) {
                return $program->accumulator;
            }
        }

        return null;
    }
}

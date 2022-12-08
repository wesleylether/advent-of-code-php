<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2015;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function md5;
use function str_starts_with;

final class Day4 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $i = 1;
        $key = $this->input[0];
        while (true) {
            $hash = md5("$key$i");
            if (str_starts_with($hash, '00000')) {
                break;
            }
            $i++;
        }
        $this->info('what number makes de hash starts with 00000?');
        $this->line($hash);
        $this->line($i);
    }

    public function two(): void
    {
        $i = 1;
        $key = $this->input[0];
        while (true) {
            $hash = md5("$key$i");
            if (str_starts_with($hash, '000000')) {
                break;
            }
            $i++;
        }
        $this->info('what number makes de hash starts with 000000?');
        $this->line($hash);
        $this->line($i);
    }
}

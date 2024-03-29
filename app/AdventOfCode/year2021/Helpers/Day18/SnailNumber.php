<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2021\Helpers\Day18;

use function json_decode;
use JsonException;

final class SnailNumber
{
    public int|SnailNumber $left;

    public int|SnailNumber $right;

    /**
     * @throws JsonException
     */
    public function __construct(
        ?string $line = null,
        public ?SnailNumber $parent = null,
    ) {
        if ($line) {
            $json = json_decode($line, false, 512, JSON_THROW_ON_ERROR);
            if (is_array($json[0])) {
                $this->left = new SnailNumber(
                    json_encode($json[0], JSON_THROW_ON_ERROR),
                    $this,
                );
            } else {
                $this->left = $json[0];
            }

            if (is_array($json[1])) {
                $this->right = new SnailNumber(
                    json_encode($json[1], JSON_THROW_ON_ERROR),
                    $this,
                );
            } else {
                $this->right = $json[1];
            }
        }
    }

    protected function updateParent(string $alpha, string $bravo): void
    {
        $current = $this;
        while ($current->parent !== null) {
            if (is_int($current->parent->{$alpha})) {
                $current->parent->{$alpha} += $this->{$alpha};

                return;
            }

            if ($current->parent->{$alpha} !== $current) {
                $current = $current->parent->{$alpha};
                while (true) {
                    if (is_int($current->{$bravo})) {
                        $current->{$bravo} += $this->{$alpha};

                        return;
                    }
                    $current = $current->{$bravo};
                }
            }

            $current = $current->parent;
        }
    }

    public function __toString(): string
    {
        return "[$this->left,$this->right]";
    }

    protected function explode(int $level): bool
    {
        if ($level >= 4 && is_int($this->left) && is_int($this->right)) {
            $this->updateParent('left', 'right');
            $this->updateParent('right', 'left');

            if ($this->parent->left === $this) {
                $this->parent->left = 0;
            }
            if ($this->parent->right === $this) {
                $this->parent->right = 0;
            }

            // We exploded, now we need to continue
            return true;
        }
        $numbers = [$this->left, $this->right];
        foreach ($numbers as $number) {
            if ($number instanceof self && $number->explode($level + 1)) {
                // We had an explosion, need to continue
                return true;
            }
        }

        // Didn't explode, we're done
        return false;
    }

    /**
     * @throws JsonException
     */
    protected function split(): bool
    {
        foreach (['left', 'right'] as $prop) {
            $value = $this->{$prop};
            if (is_int($value) && $value >= 10) {
                $snailNumber = new SnailNumber(null, $this);
                $snailNumber->left = (int) floor($value / 2);
                $snailNumber->right = (int) ceil($value / 2);
                $this->{$prop} = $snailNumber;

                return true;
            }

            if ($value instanceof self && $this->{$prop}->split()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws JsonException
     */
    public function reduce(): void
    {
        while (true) {
            $hasExploded = $this->explode(0);
            if ($hasExploded) {
                continue;
            }
            $hasSplit = $this->split();
            if ($hasSplit) {
                continue;
            }
            break;
        }
    }

    public function magnitude(): int
    {
        $magLeft = $this->left;
        if ($magLeft instanceof self) {
            $magLeft = $this->left->magnitude();
        }
        $magRight = $this->right;
        if ($magRight instanceof self) {
            $magRight = $this->right->magnitude();
        }

        return 3 * $magLeft + 2 * $magRight;
    }
}

<?php

declare(strict_types=1);

namespace App\AdventOfCode\utils\filesystem;

use Illuminate\Support\Collection;

final class Folder
{
    public function __construct(
        public readonly string $name,
        public readonly ?self $parent = null,
        public Collection $folders = new Collection(),
        public Collection $files = new Collection(),
        public int $totalSize = 0
    ) {
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function addFile(string $fileName, int $size): void
    {
        $this->files->add(new File($fileName, $size));
        $this->totalSize += $size;

        if ($this->parent) {
            $this->addSizeToParent($this->parent, $size);
        }
    }

    public function addSizeToParent(Folder $parent, int $size): void
    {
        $parent->totalSize += $size;

        if ($parent->parent) {
            $this->addSizeToParent($parent->parent, $size);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\AdventOfCode\year2022;

use App\AdventOfCode\BaseAdventOfCodeDay;
use App\AdventOfCode\utils\filesystem\Folder;
use Illuminate\Support\Collection;

final class Day7 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        // create part 1
        $filesystem = $this->generateFileSystem();
        $total = 0;
        $this->getTotalPartOne($total, $filesystem);

        $this->info('the sum of the total sizes of those directories?');
        $this->line($total);
    }

    public function two(): void
    {
        // create part 2
        $filesystem = $this->generateFileSystem();
        $freespace = 70000000 - $filesystem->totalSize;
        $folderSizeToRemove = 30000000 - $freespace;
        $foldersThatCanBeDeleted = new Collection();
        $this->getFolderSizePartTwo($foldersThatCanBeDeleted, $folderSizeToRemove, $filesystem);

        $listOfFolders = $foldersThatCanBeDeleted->sortBy('totalSize')->pluck('totalSize');

        $this->info('Find the smallest directory that, if deleted, would free up enough space on the filesystem to run the update. What is the total size of that directory?');
        $this->line($listOfFolders->first());
    }

    protected function getTotalPartOne(&$total, Folder $folder): void
    {
        if ($folder->totalSize <= 100000) {
            $total += $folder->totalSize;
        }

        foreach ($folder->folders as $childFolder) {
            $this->getTotalPartOne($total, $childFolder);
        }
    }

    protected function getFolderSizePartTwo(Collection $canDelete, int $folderSizeToRemove, Folder $folder): void
    {
        if ($folder->totalSize < $folderSizeToRemove) {
            return;
        }

        if ($folder->totalSize > $folderSizeToRemove) {
            $canDelete->add($folder);

            foreach ($folder->folders as $childFolder) {
                $this->getFolderSizePartTwo($canDelete, $folderSizeToRemove, $childFolder);
            }
        }
    }

    protected function generateFileSystem(): Folder
    {
        $current = new Folder('/');
        $fileSystem = $current;
        foreach ($this->input as $output) {
            if (preg_match('/^\$ (cd|ls)\s?(.+)?/', $output, $matches)) {
                [, $command] = $matches;
                switch ($command) {
                    case 'cd':
                        $argument = $matches[2];
                        if ($argument === '..') {
                            $current = $current->parent;
                            break;
                        }

                        foreach ($current->folders as $folder) {
                            if ($folder->name === $argument) {
                                $current = $folder;
                                break;
                            }
                        }
                        break;

                    case 'ls':
                        break;
                }
            }

            if (preg_match('/^dir (.+)/', $output, $matches)) {
                [, $dirName] = $matches;
                $current->folders->add(new Folder($dirName, $current));
            }

            if (preg_match('/^(\d+) (.+)/', $output, $matches)) {
                [, $size, $fileName] = $matches;
                $current->addFile($fileName, (int) $size);
            }
        }

        return $fileSystem;
    }
}

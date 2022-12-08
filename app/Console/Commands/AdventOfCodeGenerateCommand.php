<?php

namespace App\Console\Commands;

use function app_path;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;
use RuntimeException;
use function storage_path;

class AdventOfCodeGenerateCommand extends Command
{
    protected $signature = 'advent:of:generate {year? : Year of advent} {day? : Day of advent year}';

    protected $description = 'Generate basic file structure for advent and download file';

    protected string $year;

    protected string $day;

    public function __construct(protected Filesystem $files)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->year = $this->argument('year') ?: now()->format('Y');
        $this->day = $this->argument('day') ?: now()->format('j');

        Storage::put("$this->year/$this->day/input", $this->getAoCInputFile());

        $path = $this->getSourceFilePath();
        $this->makeDirectory($path);
        $filePath = "$path/Day$this->day.php";

        if (! $this->files->exists($filePath)) {
            $this->files->put($filePath, $this->getSourceFile());
            $this->info("File : {$filePath} created");
        } else {
            $this->info("File : {$filePath} already exits");
        }
    }

    protected function getAoCInputFile(): string
    {
        if (! ($session = config('aoc.aoc_session'))) {
            throw new RuntimeException('AoC Session Key not loaded in .env');
        }

        $response = Http::withCookies(
            [
                'session' => $session,
            ],
            '.adventofcode.com',
        )->get("https://adventofcode.com/$this->year/day/$this->day/input");

        if ($response->status() !== 200) {
            throw new RuntimeException('Could not retrieve file input');
        }

        if (! ($body = $response->body())) {
            throw new RuntimeException('Empty body retrieved');
        }

        return $body;
    }

    protected function getStubPath(): string
    {
        return __DIR__.'/../../../stubs/AoCDay.stub';
    }

    #[ArrayShape(['NAMESPACE' => 'string', 'CLASS_NAME' => 'string'])]
    protected function getStubVariables(): array
    {
        return [
            'NAMESPACE' => "App\\AdventOfCode\\year$this->year",
            'CLASS_NAME' => "Day$this->day",
        ];
    }

    protected function getSourceFile(): string
    {
        return $this->getStubContents(
            $this->getStubPath(),
            $this->getStubVariables(),
        );
    }

    protected function getStubContents($stub, $stubVariables = []): string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$'.$search.'$', $replace, $contents);
        }

        return $contents;
    }

    protected function getSourceFilePath(): string
    {
        return app_path("AdventOfCode/year$this->year");
    }

    protected function getInputFilePath(): string
    {
        return storage_path("app/$this->year/$this->day/input");
    }

    protected function makeDirectory($path): string
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}

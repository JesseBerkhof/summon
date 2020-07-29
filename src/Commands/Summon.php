<?php

declare(strict_types=1);

namespace JesseBerkhof\Summon\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class Summon extends Command
{
    public $signature = 'summon {name}';
    public $description = 'Summon a new Package.';

    private array $files;
    private array $replacements;
    private string $destinationPath;

    public function __construct()
    {
        parent::__construct();

        $this->files = config('summon.files');
        $this->replacements = config('summon.replacements');
    }

    public function handle(): void
    {
        $this->destinationPath = $this->setDestinationPath();

        if (!$this->projectPathExists()) {
            $this->error('Oh no! We can\'t find your project. Please check your config file.');
            exit(0);
        }

        $confirmMessage = 'Looks like this package already exists in your project. All files will be overwritten';

        if (
            $this->packageExists() &&
            !$this->confirm($confirmMessage, false))
        {
            exit(0);
        }

        $this->info('Summoning ' . $this->argument('name') . '...');
        $this->copyFiles();
        $this->replaceStrings();
        $this->renameFiles();
        $this->info('Your package has been summoned at ' . $this->destinationPath);
    }

    private function renameFiles(): void
    {
        $this->info('Renaming files...');

        $packageName = Str::lower($this->argument('name'));
        $className = Str::ucfirst($this->argument('name'));

        $newFileNames = str_replace(
            ['ClassName', 'package', '.stub'],
            [$className, $packageName, ''],
            $this->files
        );

        $files = array_filter(array_combine($this->files, $newFileNames), static function ($key, $value) {
            return $key !== $value;
        }, ARRAY_FILTER_USE_BOTH);

        $filesystem = new Filesystem();

        try {
            foreach ($files as $origin => $target) {
                $filesystem->rename($this->destinationPath . $origin, $this->destinationPath . $target, true);
            }
        } catch (IOExceptionInterface $exception) {
            $this->error($exception->getMessage());
        }
    }

    private function replaceStrings(): void
    {
        $packageName = $this->argument('name');

        $this->replacements['package_name'] = Str::lower($packageName);
        $this->replacements['class_name'] = Str::ucfirst($packageName);

        $this->askReplacement('Author name');
        $this->askReplacement('Author Email');
        $this->askReplacement('Author Role');
        $this->askReplacement('Namespace');

        $this->replacements['package_author'] = Str::lower($this->replacements['namespace']);

        $this->info('Replacing strings...');

        foreach ($this->files as $path) {
            foreach ($this->replacements as $search => $replace) {
                exec(sprintf("sed -i '' 's/:%s/%s/g' %s",
                    $search,
                    $replace,
                    $this->destinationPath . $path,
                ));
            }
        }
    }

    private function askReplacement(string $question, string $replacement = null): void
    {
        $attribute = Str::snake(strtolower($question));

        $this->replacements[$attribute] = $this->ask(
            $question,
            $replacement ?? config('summon.replacements.'.$attribute)
        );
    }

    private function copyFiles(): void
    {
        $this->info('Copying default files...');
        $packagePath = __DIR__.'/../Boilerplate';

        $filesystem = new Filesystem();

        try {
            $filesystem->mirror($packagePath, $this->destinationPath);
        } catch (IOExceptionInterface $exception) {
            $this->error('An error occurred while creating your directory at ' . $exception->getPath());
        }
    }

    private function projectPathExists(): bool
    {
        return file_exists(base_path());
    }

    private function packageExists(): bool
    {
        return file_exists($this->destinationPath);
    }

    private function setDestinationPath(): string
    {
        return base_path(config('summon.path') . '/' . $this->argument('name'));
    }
}


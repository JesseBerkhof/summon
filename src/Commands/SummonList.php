<?php

declare(strict_types=1);

namespace JesseBerkhof\Summon\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class SummonList extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    public $signature = 'summon:list';

    /**
     * The console command description.
     * @var string
     */
    public $description = 'Retrieve a list of available packages.';

    public function handle(Finder $finder): void
    {
        $packagesPath = base_path(config('summon.path'));
        $directories = $finder->directories()
            ->depth(0)
            ->in($packagesPath);

        $packages = [];
        foreach ($directories as $directory) {
            $packages[] = [
                $directory->getBasename(),
                $directory->getRealPath()
            ];
        }

        $this->table(['Package Name', 'Directory'], $packages);
    }
}

<?php

declare(strict_types=1);

namespace Arctic\Wraith\Commands;

use Illuminate\Console\Command;

class Summon extends Command
{
    public $signature = 'summon';

    public $description = 'Summon a new Package.';

    public function handle(): void
    {
        $this->comment('SUMMONING!');
    }
}

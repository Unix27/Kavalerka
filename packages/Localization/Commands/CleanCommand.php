<?php

namespace Localization\Commands;

use Illuminate\Console\Command;
use Localization\Helpers\Manager;

class CleanCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'translations:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean empty translations';

    protected $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->manager->cleanTranslations();
        $this->info('Done cleaning translations');
    }
}

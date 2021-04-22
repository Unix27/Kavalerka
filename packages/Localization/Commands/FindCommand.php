<?php

namespace Localization\Commands;

use Illuminate\Console\Command;
use Localization\Helpers\Manager;

class FindCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'translations:find';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find translations in php/twig files';

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
        $counter = $this->manager->findTranslations(null);
        $this->info('Done importing, processed '.$counter.' items!');
    }
}

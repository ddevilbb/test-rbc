<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\NewsImportServiceInterface;
use Illuminate\Console\Command;

class NewsImportCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'import:news';

    /**
     * @var string
     */
    protected $description = 'Import new from https://www.rbc.ru';

    private $newsImportService;

    /**
     * NewsImportCommand constructor.
     * @param NewsImportServiceInterface $newsImportService
     */
    public function __construct(NewsImportServiceInterface $newsImportService)
    {
        parent::__construct();
        $this->newsImportService = $newsImportService;
    }

    public function handle()
    {
        $this->newsImportService->run();
    }
}

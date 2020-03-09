<?php
declare(strict_types=1);

namespace App\Services;

interface NewsImportServiceInterface
{
    public function run(): void;
}

<?php
declare(strict_types=1);

namespace App\SourceProviders\Interfaces;

interface DataProviderInterface
{
    /**
     * @param string $url
     * @param int $limit
     * @return array
     */
    public function getNewsUrlList(string $url, int $limit): array;

    /**
     * @param array $urls
     * @return array
     */
    public function getNewsData(array $urls): array;
}

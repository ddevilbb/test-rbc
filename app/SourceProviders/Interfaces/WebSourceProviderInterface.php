<?php
declare(strict_types=1);

namespace App\SourceProviders\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface WebSourceProviderInterface
{
    /**
     * @param string $url
     * @return ResponseInterface
     */
    public function getResponseByUrl(string $url): ResponseInterface;

    /**
     * @param array $urls
     * @return ResponseInterface[]
     */
    public function getResponsesByUrlList(array $urls): array;
}

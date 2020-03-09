<?php
declare(strict_types=1);

namespace App\Sources\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface PageParserInterface
{
    /**
     * @param ResponseInterface $response
     * @param string $url
     * @return array
     */
    public function parseNewsData(ResponseInterface $response, string $url): array;
}

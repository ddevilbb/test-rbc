<?php
declare(strict_types=1);

namespace App\Sources\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface MainPageParserInterface
{
    /**
     * @param ResponseInterface $response
     * @param int $limit
     * @return array
     */
    public function parseNewsUrlList(ResponseInterface $response, int $limit): array;
}

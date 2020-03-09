<?php
declare(strict_types=1);

namespace App\Sources\Interfaces;

interface PageParserFactoryInterface
{
    /**
     * @param string $url
     * @return PageParserInterface
     */
    public function getParserByUrl(string $url): PageParserInterface;
}

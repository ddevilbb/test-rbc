<?php
declare(strict_types=1);

namespace App\Sources\Rbc;

use App\Exceptions\PageParserFactoryException;
use App\Sources\Interfaces\PageParserFactoryInterface;
use App\Sources\Interfaces\PageParserInterface;
use App\Sources\Rbc\Parsers\RBCDefaultPageParser;
use App\Sources\Rbc\Parsers\RBCStylePageParser;

class RBCPageParserFactory implements PageParserFactoryInterface
{
    private const RBC_MAIN_NEWS_HOST = 'rbc.ru';
    private const RBC_QUOTE_NEWS_HOST = 'quote.rbc.ru';
    private const RBC_SPORT_NEWS_HOST = 'sport.rbc.ru';
    private const RBC_STYLE_NEWS_HOST = 'style.rbc.ru';

    /**
     * @inheritDoc
     */
    public function getParserByUrl(string $url): PageParserInterface
    {
        $host = parse_url($url, PHP_URL_HOST);
        switch ($host) {
            case self::RBC_MAIN_NEWS_HOST:
            case self::RBC_QUOTE_NEWS_HOST:
            case self::RBC_SPORT_NEWS_HOST:
                return resolve(RBCDefaultPageParser::class);
            case self::RBC_STYLE_NEWS_HOST:
                return resolve(RBCStylePageParser::class);
            default:
                throw new PageParserFactoryException(sprintf('Parser for news of host %s is not implemented', $host));
        }
    }
}

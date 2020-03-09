<?php
declare(strict_types=1);

namespace App\Sources\Rbc\Parsers;

use App\Exceptions\PageParserException;
use App\Helpers\DOMDocumentHelper;
use App\Sources\Interfaces\MainPageParserInterface;
use Psr\Http\Message\ResponseInterface;

class RBCMainPageParser implements MainPageParserInterface
{
    /**
     * @inheritDoc
     */
    public function parseNewsUrlList(ResponseInterface $response, int $limit): array
    {
        $urls = [];
        $dom = DOMDocumentHelper::prepareDOMDocumentByResponse($response);
        $xpath = new \DOMXPath($dom);

        $links = $xpath->query('//div[@class="js-news-feed-list"]//a[contains(@class, "js-news-feed-item")]');
        if ($links->count() == 0) {
            throw new PageParserException('News links not found');
        }
        /** @var \DOMElement[] $links */
        foreach ($links as $link) {
            if (count($urls) === $limit) {
                break;
            }

            $urls[] = str_replace('www.', '', $link->getAttribute('href'));
        }

        return $urls;
    }
}

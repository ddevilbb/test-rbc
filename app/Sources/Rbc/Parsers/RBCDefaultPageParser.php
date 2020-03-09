<?php
declare(strict_types=1);

namespace App\Sources\Rbc\Parsers;

use App\Sources\AbstractPageParser;
use App\Sources\Interfaces\PageParserInterface;

class RBCDefaultPageParser extends AbstractPageParser implements PageParserInterface
{
    /**
     * @param \DOMXPath $DOMXPath
     * @return string
     */
    protected function parseTitle(\DOMXPath $DOMXPath): string
    {
        $nodeList = $this->findNode($DOMXPath, '//*[contains(@class, "article__header__title")]', true);

        return trim($nodeList->item(0)->textContent);
    }

    /**
     * @param \DOMXPath $DOMXPath
     * @return string
     */
    protected function parseImage(\DOMXPath $DOMXPath): string
    {
        $nodeList = $this->findNode($DOMXPath, '//img[contains(@class, "article__main-image__image")]');

        return $nodeList->count() > 0 ? $nodeList->item(0)->getAttribute('src') : '';
    }

    /**
     * @param \DOMDocument $DOMDocument
     * @param \DOMXPath $DOMXPath
     * @return string
     */
    protected function parseContent(\DOMDocument $DOMDocument, \DOMXPath $DOMXPath): string
    {
        $result = '';
        $nodeList = $this->findNode($DOMXPath, '//*[contains(@class, "article__text")]//p', true);

        foreach ($nodeList as $node) {
            $result .= !empty(trim($node->textContent)) ? trim($DOMDocument->saveHTML($node)) . PHP_EOL : '';
        }

        return $result;
    }

    /**
     * @param \DOMXPath $DOMXPath
     * @return \DateTime
     * @throws \Exception
     */
    protected function parsePublishAt(\DOMXPath $DOMXPath): \DateTime
    {
        $nodeList = $this->findNode($DOMXPath, '//*[@class="article__header__date"]', true);

        return new \DateTime($nodeList->item(0)->getAttribute('content'));
    }
}

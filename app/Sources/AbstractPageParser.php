<?php

namespace App\Sources;

use App\Exceptions\PageParserException;
use App\Helpers\DOMDocumentHelper;
use App\Helpers\NewsDataHelper;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractPageParser
{
    /**
     * @inheritDoc
     */
    public function parseNewsData(ResponseInterface $response, string $url): array
    {
        $dom = DOMDocumentHelper::prepareDOMDocumentByResponse($response);
        $xpath = new \DOMXPath($dom);

        return [
            'hash' => NewsDataHelper::generateHashByUrl($url),
            'title' => $this->parseTitle($xpath),
            'image' => $this->parseImage($xpath),
            'content' => $this->parseContent($dom, $xpath),
            'publish_at' => $this->parsePublishAt($xpath),
        ];
    }

    /**
     * @param \DOMXPath $DOMXPath
     * @param string $selector
     * @param bool $required
     * @return \DOMNodeList
     */
    protected function findNode(\DOMXPath $DOMXPath, string $selector, bool $required = false): \DOMNodeList
    {
        $nodeList = $DOMXPath->query($selector);
        if ($required && !$nodeList->count()) {
            throw new PageParserException(sprintf('Node list "%s:" not found', $selector));
        }

        return $nodeList;
    }

    /**
     * @param string $url
     * @return string
     */
    protected function generateNewsHash(string $url): string
    {
        return sha1($url);
    }

    abstract protected function parseTitle(\DOMXPath $DOMXPath): string;

    abstract protected function parseImage(\DOMXPath $DOMXPath): string;

    abstract protected function parseContent(\DOMDocument $DOMDocument, \DOMXPath $DOMXPath): string;

    abstract protected function parsePublishAt(\DOMXPath $DOMXPath): \DateTime;
}

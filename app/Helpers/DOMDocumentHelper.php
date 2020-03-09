<?php
namespace App\Helpers;

use Psr\Http\Message\ResponseInterface;

class DOMDocumentHelper
{
    public static function prepareDOMDocumentByResponse(ResponseInterface $response): \DOMDocument
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        // set error level
        $internalErrors = libxml_use_internal_errors(true);
        $dom->loadHTML($response->getBody()->getContents());
        // Restore error level
        libxml_use_internal_errors($internalErrors);

        return $dom;
    }
}

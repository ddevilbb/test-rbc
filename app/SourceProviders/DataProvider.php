<?php
declare(strict_types=1);

namespace App\SourceProviders;

use App\SourceProviders\Interfaces\DataProviderInterface;
use App\SourceProviders\Interfaces\WebSourceProviderInterface;
use App\Sources\Interfaces\MainPageParserInterface;
use App\Sources\Interfaces\PageParserFactoryInterface;

class DataProvider implements DataProviderInterface
{
    /**
     * @var WebSourceProviderInterface
     */
    private $webSourceProvider;

    /**
     * @var MainPageParserInterface
     */
    private $mainPageParser;

    /**
     * @var PageParserFactoryInterface
     */
    private $pageParserFactory;

    /**
     * DataProvider constructor.
     * @param WebSourceProviderInterface $webSourceProvider
     * @param MainPageParserInterface $mainPageParser
     * @param PageParserFactoryInterface $pageParserFactory
     */
    public function __construct(
        WebSourceProviderInterface $webSourceProvider,
        MainPageParserInterface $mainPageParser,
        PageParserFactoryInterface $pageParserFactory
    )
    {
        $this->webSourceProvider = $webSourceProvider;
        $this->mainPageParser = $mainPageParser;
        $this->pageParserFactory = $pageParserFactory;
    }

    /**
     * @inheritDoc
     */
    public function getNewsUrlList(string $url, int $limit): array
    {
        $response = $this->webSourceProvider->getResponseByUrl($url);

        return $this->mainPageParser->parseNewsUrlList($response, $limit);
    }

    /**
     * @inheritDoc
     */
    public function getNewsData(array $urls): array
    {
        $news = [];
        $responses = $this->webSourceProvider->getResponsesByUrlList($urls);

        foreach ($responses as $url => $response) {
            $parser = $this->pageParserFactory->getParserByUrl($url);
            $news[] = $parser->parseNewsData($response, $url);
        }

        return $news;
    }
}

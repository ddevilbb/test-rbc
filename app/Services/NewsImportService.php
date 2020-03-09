<?php
declare(strict_types=1);

namespace App\Services;

use App\Exceptions\NewImportServiceException;
use App\Helpers\NewsDataHelper;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\SourceProviders\Interfaces\DataProviderInterface;
use Illuminate\Support\Facades\Log;

class NewsImportService implements NewsImportServiceInterface
{
    /**
     * @var DataProviderInterface
     */
    private $dataProvider;

    /**
     * @var NewsRepositoryInterface
     */
    private $newsRepository;

    /**
     * @var string
     */
    private $url;

    /**
     * @var int
     */
    private $limit;

    public function __construct(
        DataProviderInterface $dataProvider,
        NewsRepositoryInterface $newsRepository
    )
    {
        $this->dataProvider = $dataProvider;
        $this->newsRepository = $newsRepository;
        $this->url = env('NEWS_SITE_URL');
        $this->limit = (int)env('NEWS_LIMIT');
    }

    public function run(): void
    {
        Log::info('Starting news import...');
        try {
            $urls = $this->dataProvider->getNewsUrlList($this->url, $this->limit);
            $this->removeExistsUrls($urls);
            $newsList = $this->dataProvider->getNewsData($urls);
            $this->storeNewsList($newsList);
            Log::info(sprintf('Finish import news! Added news count: %d', count($newsList)));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * @param array $urls
     */
    private function removeExistsUrls(array &$urls): void
    {
        if (empty($urls)) {
            throw new NewImportServiceException('Url list is empty');
        }

        $hashList = [];
        foreach ($urls as $url) {
            $hashList[NewsDataHelper::generateHashByUrl($url)] = $url;
        }

        $newsList = $this->newsRepository->findAllByHashList($hashList);
        foreach ($newsList->all() as $news) {
            unset($hashList[$news->hash]);
        }

        $urls = array_values($hashList);
    }

    /**
     * @param array $newsList
     */
    private function storeNewsList(array $newsList): void
    {
        if (empty($newsList)) {
            throw new NewImportServiceException('News list is empty');
        }

        foreach ($newsList as $newsItem) {
            $this->newsRepository->store($newsItem);
        }
    }
}

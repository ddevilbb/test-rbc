<?php
declare(strict_types=1);

namespace App\SourceProviders;

use App\Exceptions\WebSourceProviderException;
use App\SourceProviders\Interfaces\WebSourceProviderInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise;
use Psr\Http\Message\ResponseInterface;

class WebSourceProvider implements WebSourceProviderInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function getResponseByUrl(string $url): ResponseInterface
    {
        try {
            $response = $this->client->request('get', $url);
        } catch (GuzzleException $e) {
            throw new WebSourceProviderException($e->getMessage(), 0, $e);
        }

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new WebSourceProviderException(
                sprintf('Failed to load URL: %s. Status code: %s.', $url, $statusCode)
            );
        }

        return $response;
    }

    /**
     * @inheritDoc
     */
    public function getResponsesByUrlList(array $urls): array
    {
        $promises = [];

        foreach ($urls as $url) {
            $promises[$url] = $this->client->requestAsync('get', $url);
        }

        try {
            $responses = Promise\unwrap($promises);
        } catch (ConnectException $e) {
            throw new WebSourceProviderException($e->getMessage(), 0, $e);
        }

        return $responses;
    }
}

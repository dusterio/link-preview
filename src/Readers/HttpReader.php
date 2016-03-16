<?php

namespace Dusterio\LinkPreview\Readers;

use Dusterio\LinkPreview\Contracts\LinkInterface;
use Dusterio\LinkPreview\Contracts\ReaderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\TransferStats;

/**
 * Class HttpReader
 */
class HttpReader implements ReaderInterface
{
    /**
     * @var Client $client
     */
    private $client;

    /**
     * @return Client
     */
    public function getClient()
    {
        if (!$this->client) {
            $this->client = new Client();
        }

        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @inheritdoc
     */
    public function readLink(LinkInterface $link)
    {
        $client = $this->getClient();
        $jar = new CookieJar();

        $response = $client->request('GET', $link->getUrl(), [
            'allow_redirects' => ['max' => 10],
            'cookies' => $jar,
            'on_stats' => function (TransferStats $stats) use (&$link) {
                $link->setEffectiveUrl($stats->getEffectiveUri());
            }
        ]);

        $link->setContent($response->getBody())
            ->setContentType($response->getHeader('Content-Type')[0]);

        return $link;
    }
}

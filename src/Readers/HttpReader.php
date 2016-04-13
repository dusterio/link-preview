<?php

namespace Dusterio\LinkPreview\Readers;

use Dusterio\LinkPreview\Contracts\LinkInterface;
use Dusterio\LinkPreview\Contracts\ReaderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\TransferStats;
use GuzzleHttp\Exception\ConnectException;

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
     * @var array $config
     */
    private $config;

    /**
     * @var CookieJar $jar
     */
    private $jar;

    /**
     * HttpReader constructor.
     * @param array|null $config
     */
    public function __construct($config = null)
    {
        $this->jar = new CookieJar();

        $this->config = $config ?: [
            'allow_redirects' => ['max' => 10],
            'cookies' => $this->jar,
            'connect_timeout' => 5
        ];
    }

    /**
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $this->config(['connect_timeout' => $timeout]);
    }

    /**
     * @param array $parameters
     */
    public function config(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            $this->config[$key] = $value;
        }
    }

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

        try {
            $response = $client->request('GET', $link->getUrl(), array_merge($this->config, [
                'on_stats' => function (TransferStats $stats) use (&$link) {
                    $link->setEffectiveUrl($stats->getEffectiveUri());
                }
            ]));

            $link->setContent($response->getBody())
                ->setContentType($response->getHeader('Content-Type')[0]);
        } catch (ConnectException $e) {
            $link->setContent(false)->setContentType(false);
        }

        return $link;
    }
}

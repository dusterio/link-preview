<?php

namespace Dusterio\LinkPreview\Readers;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Dusterio\LinkPreview\Models\LinkInterface;

/**
 * Class GeneralReader
 */
class GeneralReader implements ReaderInterface
{
    /**
     * @var Client $client
     */
    private $client;
    /**
     * @inheritdoc
     */
    private $link;

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
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @inheritdoc
     */
    public function setLink(LinkInterface $link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function readLink()
    {
        $link = $this->getLink();

        $client = $this->getClient();
        $jar = new CookieJar();
        $response = $client->request('GET', $link->getUrl(), ['allow_redirects' => ['max' => 10], 'cookies' => $jar]);

        $link->setContent($response->getBody())
            ->setContentType($response->getHeader('Content-Type')[0])
            ->setRealUrl($response->getUrl());

        return $link;
    }
}

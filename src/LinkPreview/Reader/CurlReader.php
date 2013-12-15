<?php

namespace LinkPreview\Reader;

use LinkPreview\Model\LinkInterface;

class CurlReader implements ReaderInterface
{
    /**
     * @inheritdoc
     */
    private $link;

    /**
     * @var array
     */
    private $options;

    /**
     * @inheritdoc
     */
    public function setLink(LinkInterface $link)
    {
        $this->link = $link;
    }

    /**
     * @inheritdoc
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        if (null === $this->options) {
            $this->setOptions(
                array(
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER => false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_USERAGENT => "LinkPreview",
                    CURLOPT_AUTOREFERER => true,
                    CURLOPT_CONNECTTIMEOUT => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_MAXREDIRS => 5,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                )
            );
        }

        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @inheritdoc
     */
    public function getLinkData()
    {
        $link = $this->getLink();

        $ch = curl_init($link->getUrl());
        curl_setopt_array($ch, $this->getOptions());
        $content = curl_exec($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);

        $link->setContent($content);
        $link->setContentType($header['content_type']);
        $link->setRealUrl($header['url']);

        return $link;
    }
} 
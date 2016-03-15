<?php

namespace Dusterio\LinkPreview\Parser;

use Dusterio\LinkPreview\Model\Link;
use Dusterio\LinkPreview\Model\LinkInterface;
use Dusterio\LinkPreview\Reader\GeneralReader;
use Dusterio\LinkPreview\Reader\ReaderInterface;

/**
 * Class GeneralParser
 */
class GeneralParser implements ParserInterface
{
    /**
     * Url validation pattern taken from symfony UrlValidator
     */
    const PATTERN = '~^
            (http|https)://                                 # protocol
            (
                ([\pL\pN\pS-]+\.)+[\pL]+                   # a domain name
                    |                                     #  or
                \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}      # a IP address
                    |                                     #  or
                \[
                    (?:(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){6})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:::(?:(?:(?:[0-9a-f]{1,4})):){5})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){4})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,1}(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){3})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,2}(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){2})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,3}(?:(?:[0-9a-f]{1,4})))?::(?:(?:[0-9a-f]{1,4})):)(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,4}(?:(?:[0-9a-f]{1,4})))?::)(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,5}(?:(?:[0-9a-f]{1,4})))?::)(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,6}(?:(?:[0-9a-f]{1,4})))?::))))
                \]  # a IPv6 address
            )
            (:[0-9]+)?                              # a port (optional)
            (/?|/\S+)                               # a /, nothing or a / with something
        $~ixu';

    /**
     * @var LinkInterface $link
     */
    private $link;

    /**
     * @var ReaderInterface $reader
     */
    private $reader;

    /**
     * @param ReaderInterface $reader
     * @param LinkInterface   $link
     */
    public function __construct(ReaderInterface $reader = null, LinkInterface $link = null)
    {
        if (null !== $reader) {
            $this->setReader($reader);
        } else {
            $this->setReader(new GeneralReader());
        }

        if (null !== $link) {
            $this->setLink($link);
        } else {
            $this->setLink(new Link());
        }
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return 'general';
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
     * @return ReaderInterface
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @param ReaderInterface $reader
     * @return $this
     */
    public function setReader(ReaderInterface $reader)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isValidParser()
    {
        $isValid = false;

        $url = $this->getLink()->getUrl();

        if (is_string($url) && preg_match(static::PATTERN, $url)) {
            $isValid = true;
        }

        return $isValid;
    }

    /**
     * @inheritdoc
     */
    public function parseLink()
    {
        $this->readLink();

        $link = $this->getLink();

        if (!strncmp($link->getContentType(), 'text/', strlen('text/'))) {
            $htmlData = $this->parseHtml($link->getContent());

            $link->setTitle($htmlData['title'])
                ->setDescription($htmlData['description'])
                ->setImage($htmlData['image']);
        } elseif (!strncmp($link->getContentType(), 'image/', strlen('image/'))) {
            $link->setImage($link->getRealUrl());
        }

        return $link;
    }

    /**
     * Extract required data from html source
     * @param $html
     * @return array
     */
    protected function parseHtml($html)
    {
        $data = [
            'image' => '',
            'title' => '',
            'description' => ''
        ];

        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadHTML($html);

        /** @var \DOMElement $meta */
        foreach ($doc->getElementsByTagName('meta') as $meta) {
            if ($meta->getAttribute('itemprop') === 'image') {
                $data['image'] = $meta->getAttribute('content');
            } elseif ($meta->getAttribute('property') === 'og:image') {
                $data['image'] = $meta->getAttribute('content');
            } elseif ($meta->getAttribute('property') === 'twitter:image') {
                $data['image'] = $meta->getAttribute('value');
            }

            if ($meta->getAttribute('itemprop') === 'name') {
                $data['title'] = $meta->getAttribute('content');
            } elseif ($meta->getAttribute('property') === 'og:title') {
                $data['title'] = $meta->getAttribute('content');
            } elseif ($meta->getAttribute('property') === 'twitter:title') {
                $data['title'] = $meta->getAttribute('value');
            }

            if ($meta->getAttribute('itemprop') === 'description') {
                $data['title'] = $meta->getAttribute('content');
            }
            if ($meta->getAttribute('property') === 'og:description') {
                $data['description'] = $meta->getAttribute('content');
            }
        }

        if (empty($data['title'])) {
            /** @var \DOMElement $title */
            foreach ($doc->getElementsByTagName('title') as $title) {
                $data['title'] = $title->nodeValue;
            }
        }

        if (empty($data['description'])) {
            foreach ($doc->getElementsByTagName('meta') as $meta) {
                if ($meta->getAttribute('name') === 'description') {
                    $data['description'] = $meta->getAttribute('content');
                }
            }
        }

        return $data;
    }

    /**
     * Read link
     */
    private function readLink()
    {
        $reader = $this->getReader()->setLink($this->getLink());
        $this->setLink($reader->readLink());
    }
}
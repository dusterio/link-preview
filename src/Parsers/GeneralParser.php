<?php

namespace Dusterio\LinkPreview\Parsers;

use Dusterio\LinkPreview\Models\Link;
use Dusterio\LinkPreview\Models\LinkInterface;
use Dusterio\LinkPreview\Readers\GeneralReader;
use Dusterio\LinkPreview\Readers\ReaderInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class GeneralParser
 */
class GeneralParser implements ParserInterface
{
    /**
     * @var LinkInterface $link
     */
    private $link;

    /**
     * @var ReaderInterface $reader
     */
    private $reader;

    /**
     * Supported HTML tags
     *
     * @var array
     */
    private $tags = [
        'cover' => [
            ['selector' => 'meta[itemprop="image"]', 'attribute' => 'content'],
            ['selector' => 'meta[property="og:image"]', 'attribute' => 'content'],
            ['selector' => 'meta[property="twitter:image"]', 'attribute' => 'value']
        ],

        'title' => [
            ['selector' => 'meta[itemprop="name"]', 'attribute' => 'content'],
            ['selector' => 'meta[property="og:title"]', 'attribute' => 'content'],
            ['selector' => 'meta[property="twitter:title"]', 'attribute' => 'value'],
            ['selector' => 'title']
        ],

        'description' => [
            ['selector' => 'meta[itemprop="description"]', 'attribute' => 'content'],
            ['selector' => 'meta[property="og:description"]', 'attribute' => 'content'],
            ['selector' => 'meta[name="description"]', 'attribute' => 'content']
        ]
    ];

    /**
     * Smaller images will be ignored
     * @var int
     */
    private $imageMinimumWidth = 300;
    private $imageMinimumHeight = 300;

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
     * @param int $width
     * @param int $height
     */
    public function setMinimumImageDimension($width, $height)
    {
        $this->imageMinimumWidth = $width;
        $this->imageMinimumHeight = $height;
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
    public function hasParsableLink()
    {
        return !filter_var($this->getLink()->getUrl(), FILTER_VALIDATE_URL) === false;
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
                ->setDefaultImage($htmlData['cover'])
                ->setImages($htmlData['images']);
        } elseif (!strncmp($link->getContentType(), 'image/', strlen('image/'))) {
            $link->setDefaultImage($link->getRealUrl());
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
        $images = [];

        try {
            $parser = new Crawler($html);

            // Parse all known tags
            foreach($this->tags as $tag => $selectors) {
                foreach($selectors as $selector) {
                    if ($parser->filter($selector['selector'])->count() > 0) {
                        if (isset($selector['attribute'])) {
                            ${$tag} = $parser->filter($selector['selector'])->first()->attr($selector['attribute']);
                        } else {
                            ${$tag} = $parser->filter($selector['selector'])->first()->text();
                        }

                        break;
                    }
                }
            }

            foreach($parser->filter('img') as $image) {
                // This is not bulletproof, actual image maybe bigger than tags
                if ($image->hasAttribute('width') && $image->getAttribute('width') < $this->imageMinimumWidth) continue;
                if ($image->hasAttribute('height') && $image->getAttribute('height') < $this->imageMinimumHeight) continue;

                $images[] = $image->getAttribute('src');
            }
        } catch (\InvalidArgumentException $e) {
            // Ignore exceptions
        }

        $images = array_unique($images);

        if (!isset($cover) && count($images)) $cover = $images[0];

        return compact('cover', 'title', 'description', 'images');
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
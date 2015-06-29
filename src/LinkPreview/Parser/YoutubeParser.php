<?php

namespace LinkPreview\Parser;

use LinkPreview\Model\LinkInterface;
use LinkPreview\Model\VideoLink;
use LinkPreview\Reader\GeneralReader;
use LinkPreview\Reader\ReaderInterface;

/**
 * Class YoutubeParser
 */
class YoutubeParser implements ParserInterface
{
    /**
     * Url validation pattern taken from http://stackoverflow.com/questions/2964678/jquery-youtube-url-validation-with-regex
     */
    const PATTERN = '/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/';

    /**
     * @var VideoLink $link
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
            $this->setLink(new VideoLink());
        }
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return 'youtube';
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

        $link = $this->getLink();
        $url = $link->getUrl();

        if (is_string($url) && preg_match(static::PATTERN, $url, $matches)) {
            $link->setVideoId($matches[1]);
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
        $htmlData = $this->parseHtml($link->getContent());

        $link->setTitle($htmlData['title'])
            ->setDescription($htmlData['description'])
            ->setImage($htmlData['image'])
            ->setEmbedCode(
                '<iframe id="ytplayer" type="text/html" width="640" height="390" src="http://www.youtube.com/embed/'.$link->getVideoId().'" frameborder="0"/>'
            );

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
            if ($meta->getAttribute('property') === 'og:image') {
                $data['image'] = $meta->getAttribute('content');
            }

            if ($meta->getAttribute('property') === 'og:title') {
                $data['title'] = $meta->getAttribute('content');
            }

            if ($meta->getAttribute('property') === 'og:description') {
                $data['description'] = $meta->getAttribute('content');
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
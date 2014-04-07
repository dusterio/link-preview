<?php

namespace LinkPreview\Parser;

use LinkPreview\Model\LinkInterface;
use LinkPreview\Model\VideoLink;
use LinkPreview\Reader\GeneralReader;
use LinkPreview\Reader\ReaderInterface;

class YoutubeParser implements ParserInterface
{
    /**
     * Url validation pattern taken from http://stackoverflow.com/questions/2964678/jquery-youtube-url-validation-with-regex
     */
    const PATTERN = '/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/';

    const YOUTUBE_API_URL = 'http://gdata.youtube.com/feeds/api/videos/[id]?v=2&alt=jsonc';

    /**
     * @var VideoLink $link
     */
    private $link;

    /**
     * @var ReaderInterface $reader
     */
    private $reader;

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
    public function setLink(LinkInterface $link)
    {
        $this->link = $link;

        return $this;
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

    private function readLink()
    {
        $link = $this->getLink();
        $originalUrl = $link->getUrl();
        // change url to api link
        $link->setUrl(str_replace('[id]', $link->getVideoId(), self::YOUTUBE_API_URL));

        $reader = $this->getReader()->setLink($link);
        $link = $reader->readLink();
        // change to original url after reading
        $link->setUrl($originalUrl);

        $this->setLink($link);
    }

    /**
     * @inheritdoc
     */
    public function parseLink()
    {
        $this->readLink();

        $link = $this->getLink();
        $data = json_decode($link->getContent());

        $link->setTitle($data->data->title)
            ->setDescription($data->data->description)
            ->setImage($data->data->thumbnail->hqDefault)
            ->setEmbedCode(
                '<iframe id="ytplayer" type="text/html" width="640" height="390" src="http://www.youtube.com/embed/' . $link->getVideoId() . '" frameborder="0"/>'
            );

        return $link;
    }
}
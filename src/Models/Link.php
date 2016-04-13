<?php

namespace Dusterio\LinkPreview\Models;

use Dusterio\LinkPreview\Contracts\LinkInterface;
use Dusterio\LinkPreview\Exceptions\MalformedUrlException;

/**
 * Class Link
 */
class Link implements LinkInterface
{
    /**
     * @var string $content Website content
     */
    private $content;

    /**
     * @var string $contentType Website content type
     */
    private $contentType;

    /**
     * @var string $url
     */
    private $url;

    /**
     * @var string $effectiveUrl In case of redirects, this contains the final path
     */
    private $effectiveUrl;

    /**
     * @param string $url
     * @throws MalformedUrlException
     */
    public function __construct($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new MalformedUrlException();
        }

        $this->setUrl($url);
    }

    /**
     * @inheritdoc
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @inheritdoc
     */
    public function setContent($content)
    {
        $this->content = (string)$content;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @inheritdoc
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @inheritdoc
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
    /**
     * @inheritdoc
     */
    public function getEffectiveUrl()
    {
        return $this->effectiveUrl;
    }

    /**
     * @inheritdoc
     */
    public function setEffectiveUrl($effectiveUrl)
    {
        $this->effectiveUrl = $effectiveUrl;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isHtml()
    {
        return !strncmp($this->getContentType(), 'text/', strlen('text/'));
    }

    /**
     * @inheritdoc
     */
    public function isImage()
    {
        return !strncmp($this->getContentType(), 'image/', strlen('image/'));
    }

    /**
     * @inheritdoc
     */
    public function isUp()
    {
        return $this->content !== false && $this->contentType !== false;
    }
}

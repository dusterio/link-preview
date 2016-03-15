<?php

namespace Dusterio\LinkPreview\Models;

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
     * @var string $description Link description
     */
    private $description;

    /**
     * @var string $image Url to image
     */
    private $defaultImage;

    /**
     * @var array
     */
    private $images = [];

    /**
     * @var string $realUrl
     */
    private $realUrl;

    /**
     * @var string $title Link title
     */
    private $title;

    /**
     * @var string $url
     */
    private $url;

    /**
     * @param string $url
     */
    public function __construct($url = null)
    {
        if (null !== $url) {
            $this->setUrl($url);
        }
    }

    /**
     * @inheritdoc
     */
    public function getContent()
    {
        return (string)$this->content;
    }

    /**
     * @inheritdoc
     */
    public function setContent($content)
    {
        $this->content = $content;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @inheritdoc
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @inheritdoc
     */
    public function setImages(array $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultImage()
    {
        return $this->defaultImage;
    }

    /**
     * @param $image
     * @return $this
     */
    public function setDefaultImage($image)
    {
        $this->defaultImage = $image;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRealUrl()
    {
        return $this->realUrl;
    }

    /**
     * @inheritdoc
     */
    public function setRealUrl($realUrl)
    {
        $this->realUrl = $realUrl;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @inheritdoc
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
}
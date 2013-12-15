<?php

namespace LinkPreview\Model;

class Link implements LinkInterface
{
    /**
     * @var string $url
     */
    private $url;

    /**
     * @var string $realUrl
     */
    private $realUrl;

    /**
     * @var string $title Link title
     */
    private $title;

    /**
     * @var string $description Link description
     */
    private $description;

    /**
     * @var string $image Url to image
     */
    private $image;

    /**
     * @var string $content Website content
     */
    private $content;

    /**
     * @var string $contentType Website content type
     */
    private $contentType;

    public function __construct($url = null)
    {
        if (null !== $url) {
            $this->setUrl($url);
        }

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
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @inheritdoc
     */
    public function setImage($image)
    {
        $this->image = $image;

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
    public function getContent()
    {
        return $this->content;
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
}
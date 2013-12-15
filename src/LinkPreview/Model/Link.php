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
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }
}
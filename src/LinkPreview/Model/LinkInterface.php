<?php

namespace LinkPreview\Model;

interface LinkInterface
{
    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url);

    /**
     * @param string $realUrl
     * @return $this
     */
    public function setRealUrl($realUrl);

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * @param string $image
     * @return $this
     */
    public function setImage($image);

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * @param string $contentType
     * @return $this
     */
    public function setContentType($contentType);

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return string
     */
    public function getRealUrl();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return string
     */
    public function getImage();

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return string
     */
    public function getContentType();
} 
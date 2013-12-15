<?php

namespace LinkPreview\Model;

interface LinkInterface
{
    /**
     * @param string $url
     */
    public function setUrl($url);

    /**
     * @param string $realUrl
     */
    public function setRealUrl($realUrl);

    /**
     * @param string $title
     */
    public function setTitle($title);

    /**
     * @param string $description
     */
    public function setDescription($description);

    /**
     * @param string $image
     */
    public function setImage($image);

    /**
     * @param string $content
     */
    public function setContent($content);

    /**
     * @param string $contentType
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
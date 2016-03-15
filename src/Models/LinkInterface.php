<?php

namespace Dusterio\LinkPreview\Models;

/**
 * Interface LinkInterface
 */
interface LinkInterface
{
    /**
     * Get source code
     * @return string
     */
    public function getContent();

    /**
     * Get source content type (example: text/html, image/jpg)
     * @return string
     */
    public function getContentType();

    /**
     * Get description
     * @return string
     */
    public function getDescription();

    /**
     * Get image url
     * @return array
     */
    public function getImages();

    /**
     * Link cover
     * @return string|boolean
     */
    public function getDefaultImage();

    /**
     * Get real url after all redirects
     * @return string
     */
    public function getRealUrl();

    /**
     * Get title
     * @return string
     */
    public function getTitle();

    /**
     * Get website url
     * @return string
     */
    public function getUrl();

    /**
     * Set source code
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * Set source content type (example: text/html, image/jpg)
     * @param string $contentType
     * @return $this
     */
    public function setContentType($contentType);

    /**
     * Set description
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * Set image url
     * @param array $images
     * @return $this
     */
    public function setImages(array $images);

    /**
     * Image cover
     * @param $image
     * @return $this
     */
    public function setDefaultImage($image);

    /**
     * Set real url after all redirects
     * @param string $realUrl
     * @return $this
     */
    public function setRealUrl($realUrl);

    /**
     * Set title
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * Set website url
     * @param string $url
     * @return $this
     */
    public function setUrl($url);
}
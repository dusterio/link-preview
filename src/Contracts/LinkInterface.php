<?php

namespace Dusterio\LinkPreview\Contracts;

/**
 * Interface LinkInterface
 * @codeCoverageIgnore
 */
interface LinkInterface
{
    /**
     * LinkInterface constructor.
     * @param string $url
     */
    public function __construct($url);

    /**
     * Get source code
     * @return string
     */
    public function getContent();

    /**
     * Set source code
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * Get source content type (example: text/html, image/jpg)
     * @return string
     */
    public function getContentType();

    /**
     * Set source content type (example: text/html, image/jpg)
     * @param string $contentType
     * @return $this
     */
    public function setContentType($contentType);

    /**
     * Get website url
     * @return string
     */
    public function getUrl();

    /**
     * Set website url
     * @param string $url
     * @return $this
     */
    public function setUrl($url);

    /**
     * @return string
     */
    public function getEffectiveUrl();

    /**
     * @param string $effectiveUrl
     * @return $this
     */
    public function setEffectiveUrl($effectiveUrl);

    /**
     * Is this link an HTML page?
     * @return boolean
     */
    public function isHtml();

    /**
     * Is this link an image?
     * @return boolean
     */
    public function isImage();

    /**
     * Is this link functioning? (could we open it?)
     * @return boolean
     */
    public function isUp();
}
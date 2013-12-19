<?php

namespace LinkPreview\Parser;

use LinkPreview\Model\LinkInterface;

interface ParserInterface
{
    /**
     * Parser name
     *
     * @return string
     */
    public function __toString();

    /**
     * Set model
     *
     * @param LinkInterface $link
     * @return $this
     */
    public function setLink(LinkInterface $link);

    /**
     * Get model
     *
     * @return LinkInterface
     */
    public function getLink();

    /**
     * Check if parser is valid to parse for a given link
     *
     * @return boolean
     */
    public function isValidParser();

    /**
     * Parse link
     *
     * @return $this
     */
    public function parseLink();
} 
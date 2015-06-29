<?php

namespace LinkPreview\Parser;

use LinkPreview\Model\LinkInterface;
use LinkPreview\Reader\ReaderInterface;

/**
 * Interface ParserInterface
 */
interface ParserInterface
{
    /**
     * Set default reader and model
     * @param ReaderInterface $reader
     * @param LinkInterface   $link
     */
    public function __construct(ReaderInterface $reader = null, LinkInterface $link = null);

    /**
     * Parser name
     * @return string
     */
    public function __toString();

    /**
     * Get model
     * @return LinkInterface
     */
    public function getLink();

    /**
     * Get reader
     * @return ReaderInterface
     */
    public function getReader();

    /**
     * Check if parser is valid to parse for a given link
     * @return boolean
     */
    public function isValidParser();

    /**
     * Parse link
     * @return LinkInterface
     */
    public function parseLink();

    /**
     * Set model
     * @param LinkInterface $link
     * @return $this
     */
    public function setLink(LinkInterface $link);

    /**
     * Set reader
     * @param ReaderInterface $reader
     * @return $this
     */
    public function setReader(ReaderInterface $reader);
}
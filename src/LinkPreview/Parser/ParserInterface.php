<?php

namespace LinkPreview\Parser;

use LinkPreview\Model\LinkInterface;
use LinkPreview\Reader\ReaderInterface;

interface ParserInterface
{
    /**
     * Set default reader and model
     *
     *
     * @param ReaderInterface $reader
     * @param LinkInterface $link
     */
    public function __construct(ReaderInterface $reader = null, LinkInterface $link = null);

    /**
     * Parser name
     *
     * @return string
     */
    public function __toString();

    /**
     * Set reader
     *
     * @param ReaderInterface $reader
     * @return $this
     */
    public function setReader(ReaderInterface $reader);

    /**
     * Get reader
     *
     * @return ReaderInterface
     */
    public function getReader();

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
     * @return LinkInterface
     */
    public function parseLink();
} 
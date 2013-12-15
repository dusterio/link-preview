<?php

namespace LinkPreview\Parser;

use LinkPreview\Model\LinkInterface;
use LinkPreview\Reader\ReaderInterface;

interface ParserInterface
{
    /**
     * @param ReaderInterface $reader
     */
    public function __construct(ReaderInterface $reader = null);

    /**
     * Parser name
     *
     * @return string
     */
    public function __toString();

    /**
     * @param LinkInterface $link
     * @return $this
     */
    public function setLink(LinkInterface $link);

    /**
     * @return LinkInterface
     */
    public function getLink();

    /**
     * @param ReaderInterface $reader
     * @return $this
     */
    public function setReader($reader);

    /**
     * @return ReaderInterface
     */
    public function getReader();

    /**
     * @return boolean
     */
    public function isValidParser();

    /**
     * @return LinkInterface
     */
    public function getParsedLink();
} 
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
     * @param LinkInterface $link
     * @return $this
     */
    public function setLink(LinkInterface $link);

    /**
     * @return LinkInterface
     */
    public function getLink();

    /**
     * @return boolean
     */
    public function isValidParser();

    /**
     * @return $this
     */
    public function parseLink();
} 
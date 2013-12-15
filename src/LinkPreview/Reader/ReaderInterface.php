<?php

namespace LinkPreview\Reader;

use LinkPreview\Model\LinkInterface;

interface ReaderInterface
{
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
     * @return LinkInterface
     * @return $this
     */
    public function readLink();
} 
<?php

namespace LinkPreview\Reader;

use LinkPreview\Model\LinkInterface;

interface ReaderInterface
{
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
     * Read and update model
     *
     * @return LinkInterface
     */
    public function readLink();
} 
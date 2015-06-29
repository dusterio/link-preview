<?php

namespace LinkPreview\Reader;

use LinkPreview\Model\LinkInterface;

/**
 * Interface ReaderInterface
 */
interface ReaderInterface
{
    /**
     * Get model
     * @return LinkInterface
     */
    public function getLink();

    /**
     * Read and update model
     * @return LinkInterface
     */
    public function readLink();

    /**
     * Set model
     * @param LinkInterface $link
     * @return $this
     */
    public function setLink(LinkInterface $link);
}
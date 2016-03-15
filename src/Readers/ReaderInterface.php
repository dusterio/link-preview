<?php

namespace Dusterio\LinkPreview\Readers;

use Dusterio\LinkPreview\Models\LinkInterface;

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
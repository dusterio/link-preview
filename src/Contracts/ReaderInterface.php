<?php

namespace Dusterio\LinkPreview\Contracts;

/**
 * Interface ReaderInterface
 */
interface ReaderInterface
{
    /**
     * @param LinkInterface $link
     * @return LinkInterface
     */
    public function readLink(LinkInterface $link);
}
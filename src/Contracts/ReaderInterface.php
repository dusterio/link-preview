<?php

namespace Dusterio\LinkPreview\Contracts;

/**
 * Interface ReaderInterface
 * @codeCoverageIgnore
 */
interface ReaderInterface
{
    /**
     * @param LinkInterface $link
     * @return LinkInterface
     */
    public function readLink(LinkInterface $link);
}
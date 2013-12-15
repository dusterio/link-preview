<?php

namespace LinkPreview\Reader;

use LinkPreview\Model\LinkInterface;

interface ReaderInterface
{
    /**
     * @param LinkInterface $link
     */
    public function setLink(LinkInterface $link);

    /**
     * @return LinkInterface
     */
    public function getLink();

    /**
     * @return LinkInterface
     */
    public function getLinkData();
} 
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

    /**
     * @param array $parameters
     * @return void
     */
    public function config(array $parameters);
}
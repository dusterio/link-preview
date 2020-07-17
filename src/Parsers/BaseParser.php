<?php

namespace Dusterio\LinkPreview\Parsers;

use Dusterio\LinkPreview\Contracts\LinkInterface;
use Dusterio\LinkPreview\Contracts\PreviewInterface;
use Dusterio\LinkPreview\Contracts\ReaderInterface;

abstract class BaseParser
{
    /**
     * @var ReaderInterface
     */
    private $reader;

    /**
     * @var PreviewInterface
     */
    private $preview;

    public function getPreview()
    {
        return $this->preview;
    }

    public function setPreview(PreviewInterface $preview)
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * @return ReaderInterface
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @param ReaderInterface $reader
     *
     * @return $this
     */
    public function setReader(ReaderInterface $reader)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * Read link.
     *
     * @param LinkInterface $link
     *
     * @return LinkInterface
     */
    protected function readLink(LinkInterface $link)
    {
        return $this->getReader()->readLink($link);
    }
}

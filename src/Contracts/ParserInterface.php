<?php

namespace Dusterio\LinkPreview\Contracts;
use Dusterio\LinkPreview\Models\Preview;

/**
 * Interface ParserInterface
 * @codeCoverageIgnore
 */
interface ParserInterface
{
    /**
     * Set default reader and model
     * @param ReaderInterface $reader
     * @param PreviewInterface $preview
     */
    public function __construct(ReaderInterface $reader = null, PreviewInterface $preview);

    /**
     * Parsers name
     * @return string
     */
    public function __toString();

    /**
     * Get reader
     * @return ReaderInterface
     */
    public function getReader();

    /**
     * Set reader
     * @param ReaderInterface $reader
     * @return $this
     */
    public function setReader(ReaderInterface $reader);

    /**
     * @return PreviewInterface
     */
    public function getPreview();

    /**
     * @param PreviewInterface $preview
     * @return $this
     */
    public function setPreview(PreviewInterface $preview);

    /**
     * Can this parser parse the link supplied?
     * @param LinkInterface $link
     * @return boolean
     */
    public function canParseLink(LinkInterface $link);

    /**
     * Parse link
     * @param LinkInterface $link
     * @return $this
     */
    public function parseLink(LinkInterface $link);
}
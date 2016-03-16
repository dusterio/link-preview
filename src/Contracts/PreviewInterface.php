<?php

namespace Dusterio\LinkPreview\Contracts;

/**
 * Interface PreviewInterface
 */
interface PreviewInterface
{
    /**
     * Return a list of parsable attributes
     * @return array
     */
    public function getFields();

    /**
     * Return all parsed data as an array
     * @return array
     */
    public function toArray();
}
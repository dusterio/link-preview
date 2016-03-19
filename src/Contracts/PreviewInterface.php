<?php

namespace Dusterio\LinkPreview\Contracts;

/**
 * Interface PreviewInterface
 * @codeCoverageIgnore
 */
interface PreviewInterface
{
    /**
     * Return a list of parsable attributes
     * @return array
     */
    public function getFields();

    /**
     * Mass assignment of class properties
     * @param array $params
     * @return $this
     */
    public function update(array $params);

    /**
     * Return all parsed data as an array
     * @return array
     */
    public function toArray();
}
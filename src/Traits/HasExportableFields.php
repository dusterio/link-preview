<?php

namespace Dusterio\LinkPreview\Traits;

trait HasExportableFields
{
    /**
     * @inheritdoc
     */
    public function getFields()
    {
        return isset($this->fields) ? $this->fields : [];
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        $output = [];

        if (!isset($this->fields)) return $output;

        foreach ($this->fields as $field) {
            $output[$field] = $this->{$field};
        }

        return $output;
    }
}
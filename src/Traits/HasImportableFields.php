<?php

namespace Dusterio\LinkPreview\Traits;

use Dusterio\LinkPreview\Exceptions\UnknownFieldException;

trait HasImportableFields
{
    /**
     * @param $methodName
     * @param $args
     * @return string|array
     * @throws UnknownFieldException
     */
    public function __call($methodName, $args)
    {
        if (preg_match('~^(set|get)([A-Z])(.*)$~', $methodName, $matches)) {
            $property = strtolower($matches[2]) . $matches[3];

            if (!property_exists($this, $property) || !in_array($property, $this->fields)) {
                throw new UnknownFieldException();
            }

            switch ($matches[1]) {
                case 'set':
                    $this->{$property} = $args[0];

                    return $this;

                case 'get':
                    return $this->{$property};

                case 'default':
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function update(array $params)
    {
        foreach($params as $property => $value) {
            if (!property_exists($this, $property) || array_key_exists($property, $this->fields)) {
                throw new UnknownFieldException();
            }

            $this->{$property} = $value;
        }
    }
}
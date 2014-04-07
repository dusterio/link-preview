<?php

namespace LinkPreview;

use LinkPreview\Model\LinkInterface;
use LinkPreview\Parser\GeneralParser;
use LinkPreview\Parser\ParserInterface;
use LinkPreview\Parser\YoutubeParser;

class LinkPreview
{
    /**
     * @var string $url
     */
    private $url;

    /**
     * @var ParserInterface[]
     */
    private $parsers = array();

    /**
     * @var boolean
     */
    private $propagation = false;

    /**
     * @param string|null $url
     */
    public function __construct($url = null)
    {
        if (null !== $url) {
            $this->setUrl($url);
        }
    }

    /**
     * Set website url to a general model
     *
     * @param string $url Website url to parse information from
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get propagation
     *
     * @return boolean
     */
    public function getPropagation()
    {
        return $this->propagation;
    }

    /**
     * Set propagation for parsing.
     * If propagation is set to false, then parsing stops after first successful parsing.
     * By default it is set as false.
     *
     * @param boolean $propagation
     * @return $this
     */
    public function setPropagation($propagation)
    {
        $this->propagation = $propagation;

        return $this;
    }

    /**
     * Get parsers
     *
     * @return ParserInterface[]
     */
    public function getParsers()
    {
        return $this->parsers;
    }

    /**
     * Set parsers
     *
     * @param ParserInterface[] $parsers
     * @return $this
     */
    public function setParsers($parsers)
    {
        $this->parsers = $parsers;

        return $this;
    }

    /**
     * Add parser to the beginning of parsers list
     *
     * @param ParserInterface $parser
     * @return $this
     */
    public function addParser(ParserInterface $parser)
    {
        $this->parsers = array($parser->__toString() => $parser) + $this->parsers;

        return $this;
    }

    /**
     * Remove parser from parsers list
     *
     * @param string $name Parser name
     * @return $this
     */
    public function removeParser($name)
    {
        if (in_array($name, $this->parsers)) {
            unset($this->parsers[$name]);
        }

        return $this;
    }

    /**
     * Get parsed model array with parser name as a key
     *
     * @return LinkInterface[]
     */
    public function getParsed()
    {
        $parsed = array();

        $parsers = $this->getParsers();
        if (empty($parsers)) {
            $this->addDefaultParsers();
        }

        foreach ($this->getParsers() as $name => $parser) {
            $parser->getLink()->setUrl($this->getUrl());

            if ($parser->isValidParser()) {
                $parsed[$name] = $parser->parseLink();

                if (!$this->getPropagation()) {
                    break;
                }
            }
        }

        return $parsed;
    }

    /**
     * Add default parsers
     */
    protected function addDefaultParsers()
    {
        $this->addParser(new GeneralParser());
        $this->addParser(new YoutubeParser());
    }
}
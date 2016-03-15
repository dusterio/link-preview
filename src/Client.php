<?php

namespace Dusterio\LinkPreview;

use Dusterio\LinkPreview\Models\LinkInterface;
use Dusterio\LinkPreview\Parsers\GeneralParser;
use Dusterio\LinkPreview\Parsers\ParserInterface;
use Dusterio\LinkPreview\Parsers\YouTubeParser;

class Client
{
    /**
     * @var ParserInterface[]
     */
    private $parsers = [];

    /**
     * In single mode a link will only be parsed with the first parser that found it feasible
     *
     * @var boolean
     */
    private $singleMode = true;

    /**
     * @var string $url
     */
    private $url;

    /**
     * @param string $url Request address
     */
    public function __construct($url = null)
    {
        if ($url) $this->setUrl($url);
    }

    /**
     * Add parser to the beginning of parsers list
     *
     * @param ParserInterface $parser
     * @return $this
     */
    public function addParser(ParserInterface $parser)
    {
        $this->parsers = [(string) $parser => $parser] + $this->parsers;

        return $this;
    }

    /**
     * Get parsed model array with parser name as a key
     * @return LinkInterface[]
     */
    public function getParsed()
    {
        $parsed = [];

        $parsers = $this->getParsers();

        if (0 === count($parsers)) {
            $this->addDefaultParsers();
        }

        foreach ($this->getParsers() as $name => $parser) {
            $parser->getLink()->setUrl($this->getUrl());

            if ($parser->hasParsableLink()) {
                $parsed[$name] = $parser->parseLink();

                if ($this->isSingleMode()) break;
            }
        }

        return $parsed;
    }

    /**
     * Get parsers
     * @return ParserInterface[]
     */
    public function getParsers()
    {
        return $this->parsers;
    }

    /**
     * Set parsers
     * @param ParserInterface[] $parsers
     * @return $this
     */
    public function setParsers($parsers)
    {
        $this->parsers = $parsers;

        return $this;
    }

    /**
     * Are we in a single mode?
     *
     * @return boolean
     */
    public function isSingleMode()
    {
        return $this->singleMode;
    }

    /**
     * Set single mode on/off
     *
     * @param boolean $mode
     * @return $this
     */
    public function setSingleMode($mode)
    {
        $this->singleMode = $mode;

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
     * Set target url
     *
     * @param string $url Website url to parse
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

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
        if (in_array($name, $this->parsers, false)) {
            unset($this->parsers[$name]);
        }

        return $this;
    }

    /**
     * Add default parsers
     */
    protected function addDefaultParsers()
    {
        $this->addParser(new GeneralParser());
        $this->addParser(new YouTubeParser());
    }
}
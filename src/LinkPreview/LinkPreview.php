<?php

namespace LinkPreview;

use LinkPreview\Model\Link;
use LinkPreview\Model\LinkInterface;
use LinkPreview\Parser\GeneralParser;
use LinkPreview\Parser\ParserInterface;
use LinkPreview\Reader\GeneralReader;
use LinkPreview\Reader\ReaderInterface;

class LinkPreview
{
    /**
     * @var LinkInterface $link
     */
    private $link;

    /**
     * @var ReaderInterface $reader
     */
    private $reader;

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
     * @param string $url Website url to parse information from
     * @return $this
     */
    public function setUrl($url)
    {
        $this->setLink(new Link($url));

        return $this;
    }

    /**
     * @param LinkInterface $link Link model
     * @return $this
     */
    public function setLink(LinkInterface $link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return LinkInterface
     */
    public function getLink()
    {
        return $this->link;
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
     * @return $this
     */
    public function setReader($reader)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
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
     * @return ParserInterface[]
     */
    public function getParsers()
    {
        return $this->parsers;
    }

    /**
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
     * @return LinkInterface[]
     */
    public function getParsed()
    {
        $parsed = array();

        if (null === $this->getParsers()) {
            $this->addDefaultParsers();
        }

        if (null === $this->getReader()) {
            $this->setReader(new GeneralReader());
        }

        $reader = $this->getReader()->setLink($this->getLink());
        $link = $reader->readLink()->getLink();
        $this->setLink($link);

        foreach ($this->getParsers() as $name => $parser) {
            $parser->setLink($this->getLink());

            if ($parser->isValidParser()) {
                $parsed[$name] = $parser->parseLink()->getLink();

                if (!$this->getPropagation()) {
                    break;
                }
            }
        }

        return $parsed;
    }

    /**
     * Add default parsers from directory
     */
    protected function addDefaultParsers()
    {
        $this->addParser(new GeneralParser());
    }
}
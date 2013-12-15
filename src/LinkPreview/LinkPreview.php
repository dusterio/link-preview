<?php

namespace LinkPreview;

use LinkPreview\Model\Link;
use LinkPreview\Model\LinkInterface;
use LinkPreview\Parser\GeneralParser;
use LinkPreview\Parser\ParserInterface;
use LinkPreview\Reader\CurlReader;

class LinkPreview
{
    /**
     * @var LinkInterface $link
     */
    private $link;

    /**
     * @var ParserInterface[]
     */
    private $parsers = array();

    /**
     * @var boolean
     */
    private $propagation = true;

    /**
     * @param string $url Website url to parse information from
     */
    public function setUrl($url)
    {
        $this->setLink(new Link($url));
    }

    /**
     * @param LinkInterface $link Link model
     */
    public function setLink(LinkInterface $link)
    {
        $this->link = $link;
    }

    /**
     * @return LinkInterface
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return boolean
     */
    public function getPropagation()
    {
        return $this->propagation;
    }

    /**
     * @param boolean $propagation
     */
    public function setPropagation($propagation)
    {
        $this->propagation = $propagation;
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
     */
    public function setParsers($parsers)
    {
        $this->parsers = $parsers;
    }

    /**
     * Add parser to the beginning of parsers list
     *
     * @param ParserInterface $parser
     */
    public function addParser(ParserInterface $parser)
    {
        $this->parsers = array($parser->__toString() => $parser) + $this->parsers;
    }

    /**
     * @param string $name Parser name
     */
    public function removeParser($name)
    {
        if (in_array($name, $this->parsers)) {
            unset($this->parsers[$name]);
        }
    }

    /**
     * @return LinkInterface[]
     */
    public function getParsed()
    {
        $parsed = array();

        if (empty($this->parsers)) {
            $this->addDefaultParsers();
        }

        foreach ($this->getParsers() as $name => $parser) {
            $parser->setLink($this->getLink());

            if ($parser->isValidParser()) {
                $parsed[$name] = $parser->getParsedLink();

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
        $this->addParser(new GeneralParser(new CurlReader()));
    }
}
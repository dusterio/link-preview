<?php

namespace Dusterio\LinkPreview;

use Dusterio\LinkPreview\Contracts\ParserInterface;
use Dusterio\LinkPreview\Contracts\PreviewInterface;
use Dusterio\LinkPreview\Parsers\HtmlParser;
use Dusterio\LinkPreview\Parsers\YouTubeParser;
use Dusterio\LinkPreview\Parsers\VimeoParser;
use Dusterio\LinkPreview\Models\Link;
use Dusterio\LinkPreview\Exceptions\UnknownParserException;

class Client
{
    /**
     * @var ParserInterface[]
     */
    private $parsers = [];

    /**
     * @var Link $link
     */
    private $link;

    /**
     * @param string $url Request address
     */
    public function __construct($url = null)
    {
        if ($url) $this->setUrl($url);
        $this->addDefaultParsers();
    }

    /**
     * Try to get previews from as many parsers as possible
     * @return PreviewInterface[]
     */
    public function getPreviews()
    {
        $parsed = [];

        foreach ($this->getParsers() as $name => $parser) {
            if ($parser->canParseLink($this->link))
                $parsed[$name] = $parser->parseLink($this->link)->getPreview();
        }

        return $parsed;
    }

    /**
     * Get a preview from a single parser
     * @param string $parserId
     * @throws UnknownParserException
     * @return PreviewInterface|boolean
     */
    public function getPreview($parserId)
    {
        if (array_key_exists($parserId, $this->getParsers())) {
            $parser = $this->getParsers()[$parserId];
        } else throw new UnknownParserException();

        return $parser->parseLink($this->link)->getPreview();
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
     * @param $id
     * @return bool|ParserInterface
     */
    public function getParser($id)
    {
        return isset($this->parsers[$id]) ? $this->parsers[$id] : false;
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
     * @return string
     */
    public function getUrl()
    {
        return (!empty($this->link->getEffectiveUrl())) ? $this->link->getEffectiveUrl() : $this->link->getUrl();
    }

    /**
     * Set target url
     *
     * @param string $url Website url to parse
     * @return $this
     */
    public function setUrl($url)
    {
        $this->link = new Link($url);

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
     * @return void
     */
    protected function addDefaultParsers()
    {
        $this->addParser(new HtmlParser());
        $this->addParser(new YouTubeParser());
        $this->addParser(new VimeoParser());
    }
}
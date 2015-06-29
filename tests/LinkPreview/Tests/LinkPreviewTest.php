<?php

namespace LinkPreview\Tests;

use LinkPreview\LinkPreview;

class LinkPreviewTest extends \PHPUnit_Framework_TestCase
{
    public function testAddDefaultParsers()
    {
        $linkPreview = new LinkPreview();
        $linkPreview->getParsed();

        self::assertArrayHasKey('general', $linkPreview->getParsers());
    }

    public function testAddParser()
    {
        $generalParserMock = $this->getMock('LinkPreview\Parser\GeneralParser', null);
        $youtubeParserMock = $this->getMock('LinkPreview\Parser\YoutubeParser', null);

        $linkPreview = new LinkPreview();

        // check if parser is added to the list
        $linkPreview->addParser($generalParserMock);
        $parsers = $linkPreview->getParsers();
        self::assertContains('general', $parsers);

        // check if parser added to the beginning of the list
        $linkPreview->addParser($youtubeParserMock);
        $parsers = $linkPreview->getParsers();
        self::assertEquals('youtube', key($parsers));

        return $linkPreview;
    }

    public function testGetParsed()
    {
        $linkMock = $this->getMock('LinkPreview\Model\Link', null);

        $generalParserMock = $this->getMock('LinkPreview\Parser\GeneralParser');
        $generalParserMock->expects(self::once())
            ->method('getLink')
            ->will(self::returnValue($linkMock));
        $generalParserMock->expects(self::once())
            ->method('isValidParser')
            ->will(self::returnValue(true));
        $generalParserMock->expects(self::once())
            ->method('__toString')
            ->will(self::returnValue('general'));
        $generalParserMock->expects(self::once())
            ->method('parseLink')
            ->will(self::returnValue($linkMock));

        $linkPreview = new LinkPreview();
        $linkPreview->setPropagation(false);
        $linkPreview->addParser($generalParserMock);
        $parsed = $linkPreview->getParsed();

        self::assertArrayHasKey('general', $parsed);
    }

    /**
     * @depends testAddParser
     */
    public function testRemoveParser(LinkPreview $linkPreview)
    {
        $linkPreview->removeParser('general');
        $parsers = $linkPreview->getParsers();
        self::assertNotContains('general', $parsers);
    }

    public function testSetUrl()
    {
        $linkPreview = new LinkPreview('http://github.com');
        self::assertEquals('http://github.com', $linkPreview->getUrl());
    }

    public function testYoutube()
    {
        $linkPreview = new LinkPreview('https://www.youtube.com/watch?v=C0DPdy98e4c');
        $parsedLink = current($linkPreview->getParsed());
        self::assertInstanceOf('LinkPreview\Model\VideoLink', $parsedLink);
    }
}
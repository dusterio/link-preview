<?php

namespace Dusterio\LinkPreview\Tests;

use Dusterio\LinkPreview\Client;

class LinkPreviewTest extends \PHPUnit_Framework_TestCase
{
    public function testAddDefaultParsers()
    {
        $linkPreview = new Client();
        $linkPreview->getParsed();

        self::assertArrayHasKey('general', $linkPreview->getParsers());
    }

    public function testAddParser()
    {
        $generalParserMock = $this->getMock('Dusterio\LinkPreview\Parsers\GeneralParser', null);
        $youtubeParserMock = $this->getMock('Dusterio\LinkPreview\Parsers\YouTubeParser', null);

        $linkPreview = new Client();

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
        $linkMock = $this->getMock('Dusterio\LinkPreview\Models\Link', null);

        $generalParserMock = $this->getMock('Dusterio\LinkPreview\Parsers\GeneralParser');
        $generalParserMock->expects(self::once())
            ->method('getLink')
            ->will(self::returnValue($linkMock));
        $generalParserMock->expects(self::once())
            ->method('hasParsableLink')
            ->will(self::returnValue(true));
        $generalParserMock->expects(self::once())
            ->method('__toString')
            ->will(self::returnValue('general'));
        $generalParserMock->expects(self::once())
            ->method('parseLink')
            ->will(self::returnValue($linkMock));

        $linkPreview = new Client();
        $linkPreview->setSingleMode(false);
        $linkPreview->addParser($generalParserMock);
        $parsed = $linkPreview->getParsed();

        self::assertArrayHasKey('general', $parsed);
    }

    /**
     * @depends testAddParser
     */
    public function testRemoveParser(Client $linkPreview)
    {
        $linkPreview->removeParser('general');
        $parsers = $linkPreview->getParsers();
        self::assertNotContains('general', $parsers);
    }

    public function testSetUrl()
    {
        $linkPreview = new Client('http://github.com');
        self::assertEquals('http://github.com', $linkPreview->getUrl());
    }

    public function testYoutube()
    {
        $linkPreview = new Client('https://www.youtube.com/watch?v=C0DPdy98e4c');
        $parsedLink = current($linkPreview->getParsed());
        self::assertInstanceOf('Dusterio\LinkPreview\Models\VideoLink', $parsedLink);
    }
}
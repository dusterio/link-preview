<?php

namespace LinkPreview\Tests;

use LinkPreview\LinkPreview;

class LinkPreviewTest extends \PHPUnit_Framework_TestCase
{
    public function testAddParser()
    {
        $generalParserMock = $this->getMock('LinkPreview\Parser\GeneralParser', null);
        $youtubeParserMock = $this->getMock('LinkPreview\Parser\YoutubeParser', null);

        $linkPreview = new LinkPreview();

        // check if parser is added to the list
        $linkPreview->addParser($generalParserMock);
        $parsers = $linkPreview->getParsers();
        $this->assertContains('general', $parsers);

        // check if parser added to the beginning of the list
        $linkPreview->addParser($youtubeParserMock);
        $parsers = $linkPreview->getParsers();
        $this->assertEquals('youtube', key($parsers));

        return $linkPreview;
    }

    /**
     * @depends testAddParser
     */
    public function testRemoveParser(LinkPreview $linkPreview)
    {
        $linkPreview->removeParser('general');
        $parsers = $linkPreview->getParsers();
        $this->assertNotContains('general', $parsers);
    }

    public function testGetParsed()
    {
        $linkMock = $this->getMock('LinkPreview\Model\Link', null);

        $generalParserMock = $this->getMock('LinkPreview\Parser\GeneralParser');
        $generalParserMock->expects($this->once())
            ->method('getLink')
            ->will($this->returnValue($linkMock));
        $generalParserMock->expects($this->once())
            ->method('isValidParser')
            ->will($this->returnValue(true));
        $generalParserMock->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue('general'));
        $generalParserMock->expects($this->once())
            ->method('parseLink')
            ->will($this->returnValue($linkMock));

        $linkPreview = new LinkPreview();
        $linkPreview->setPropagation(false);
        $linkPreview->addParser($generalParserMock);
        $parsed = $linkPreview->getParsed();

        $this->assertArrayHasKey('general', $parsed);
    }

    public function testAddDefaultParsers()
    {
        $linkPreview = new LinkPreview();
        $linkPreview->getParsed();

        $this->assertArrayHasKey('general', $linkPreview->getParsers());
    }

    public function testSetUrl()
    {
        $linkPreview = new LinkPreview('http://github.com');
        $this->assertEquals('http://github.com', $linkPreview->getUrl());
    }
}
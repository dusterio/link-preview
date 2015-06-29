<?php

namespace LinkPreview\Tests\Reader;

use LinkPreview\Reader\GeneralReader;

class GeneralReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testReadLink()
    {
        $responseMock = $this->getMock(
            'Guzzle\Http\Message\Response',
            ['getBody', 'getContentType', 'getEffectiveUrl'],
            [],
            '',
            false
        );
        $responseMock->expects(self::once())
            ->method('getBody')
            ->will(self::returnValue('body'));
        $responseMock->expects(self::once())
            ->method('getContentType')
            ->will(self::returnValue('text/html'));
        $responseMock->expects(self::once())
            ->method('getEffectiveUrl')
            ->will(self::returnValue('http://github.com'));

        $requestMock = $this->getMock(
            'Guzzle\Http\Message\Request',
            ['send'],
            [],
            '',
            false
        );
        $requestMock->expects(self::once())
            ->method('send')
            ->will(self::returnValue($responseMock));

        $clientMock = $this->getMock('Guzzle\Http\Client');
        $clientMock->expects(self::once())
            ->method('get')
            ->will(self::returnValue($requestMock));

        $linkMock = $this->getMock('LinkPreview\Model\Link', null);

        $reader = new GeneralReader();
        $reader->setClient($clientMock);
        $reader->setLink($linkMock);
        $link = $reader->readLink();

        self::assertEquals('body', $link->getContent());
        self::assertEquals('text/html', $link->getContentType());
        self::assertEquals('http://github.com', $link->getRealUrl());
    }
}

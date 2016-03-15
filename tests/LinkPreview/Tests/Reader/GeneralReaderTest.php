<?php

namespace Dusterio\LinkPreview\Tests\Reader;

use Dusterio\LinkPreview\Readers\GeneralReader;

class GeneralReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testReadLink()
    {
        $responseMock = $this->getMock(
            'Psr\Http\Message\ResponseInterface',
            ['getBody', 'getContentType', 'getEffectiveUrl', 'getStatusCode', 'withStatus', 'getReasonPhrase',
            'getProtocolVersion', 'withProtocolVersion', 'getHeader', 'getHeaders', 'hasHeader', 'withHeader',
            'getHeaderLine', 'withAddedHeader', 'withoutHeader', 'withBody'],
            [],
            '',
            false
        );

        $responseMock->expects(self::once())
            ->method('getBody')
            ->will(self::returnValue('body'));

        $responseMock->expects(self::once())
            ->method('getHeader')
            ->will(self::returnValue(['text/html']));

        $responseMock->expects(self::once())
            ->method('getEffectiveUrl')
            ->will(self::returnValue('http://github.com'));

        $requestMock = $this->getMock(
            'Psr\Http\Message\RequestInterface',
            ['send', 'getRequestTarget', 'withRequestTarget', 'getMethod', 'withMethod', 'getUri', 'getProtocolVersion',
            'withProtocolVersion', 'getHeaders', 'hasHeader', 'getHeaderLine', 'getHeader', 'withHeader', 'withUri',
            'withAddedHeader', 'withoutHeader', 'getBody', 'withBody'],
            [],
            '',

            false
        );

        $requestMock->expects(self::once())
            ->method('send')
            ->will(self::returnValue($responseMock));

        $clientMock = $this->getMock('GuzzleHttp\Client');
        $clientMock->expects(self::once())
            ->method('get')
            ->will(self::returnValue($responseMock));

        $linkMock = $this->getMock('Dusterio\LinkPreview\Models\Link', null);

        $reader = new GeneralReader();
        $reader->setClient($clientMock);
        $reader->setLink($linkMock);
        $link = $reader->readLink();

        self::assertEquals('body', $link->getContent());
        self::assertEquals('text/html', $link->getContentType());
        self::assertEquals('http://github.com', $link->getRealUrl());
    }
}

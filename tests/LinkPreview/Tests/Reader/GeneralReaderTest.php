<?php

namespace Dusterio\LinkPreview\Tests\Reader;

use Dusterio\LinkPreview\Readers\HttpReader;

class GeneralReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_load_a_web_page()
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

        /*$responseMock->expects(self::once())
            ->method('getEffectiveUrl')
            ->will(self::returnValue('http://github.com'));*/

        $requestMock = $this->getMock(
            'Psr\Http\Message\RequestInterface',
            ['send', 'getRequestTarget', 'withRequestTarget', 'getMethod', 'withMethod', 'getUri', 'getProtocolVersion',
            'withProtocolVersion', 'getHeaders', 'hasHeader', 'getHeaderLine', 'getHeader', 'withHeader', 'withUri',
            'withAddedHeader', 'withoutHeader', 'getBody', 'withBody'],
            [],
            '',

            false
        );

        $clientMock = $this->getMock('GuzzleHttp\Client');
        $clientMock->expects(self::once())
            ->method('request')
            ->will(self::returnValue($responseMock));

        $linkMock = $this->getMock('Dusterio\LinkPreview\Models\Link', null, ['http://www.google.com']);

        $reader = new HttpReader();
        $reader->setClient($clientMock);
        $link = $reader->readLink($linkMock);

        self::assertEquals('body', $link->getContent());
        self::assertEquals('text/html', $link->getContentType());
        self::assertEquals('http://www.google.com', $link->getUrl());
    }
}

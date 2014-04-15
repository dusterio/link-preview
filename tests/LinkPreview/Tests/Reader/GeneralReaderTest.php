<?php

namespace LinkPreview\Tests\Reader;

use LinkPreview\Reader\GeneralReader;

class GeneralReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testReadLink()
    {
        $responseMock = $this->getMock(
            'Guzzle\Http\Message\Response',
            array('getBody', 'getContentType', 'getEffectiveUrl'),
            array(),
            '',
            false
        );
        $responseMock->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue('body'));
        $responseMock->expects($this->once())
            ->method('getContentType')
            ->will($this->returnValue('text/html'));
        $responseMock->expects($this->once())
            ->method('getEffectiveUrl')
            ->will($this->returnValue('http://github.com'));

        $requestMock = $this->getMock(
            'Guzzle\Http\Message\Request',
            array('send'),
            array(),
            '',
            false
        );
        $requestMock->expects($this->once())
            ->method('send')
            ->will($this->returnValue($responseMock));

        $clientMock = $this->getMock('Guzzle\Http\Client');
        $clientMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($requestMock));

        $linkMock = $this->getMock('LinkPreview\Model\Link', null);

        $reader = new GeneralReader();
        $reader->setClient($clientMock);
        $reader->setLink($linkMock);
        $link = $reader->readLink();

        $this->assertEquals('body', $link->getContent());
        $this->assertEquals('text/html', $link->getContentType());
        $this->assertEquals('http://github.com', $link->getRealUrl());
    }
}
 
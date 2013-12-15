<?php

namespace LinkPreview\Tests\Parser;

use LinkPreview\Parser\GeneralParser;

class GeneralParserTest extends \PHPUnit_Framework_TestCase
{
    public function testIsValidParser()
    {
        $linkMock = $this->getMockBuilder('LinkPreview\Model\Link')
            ->setMethods(null)
            ->getMock();

        $parser = new GeneralParser();
        $parser->setLink($linkMock->setUrl('http://github.com'));
        $this->assertTrue($parser->isValidParser());

        $parser->setLink($linkMock->setUrl('http://trololo'));
        $this->assertFalse($parser->isValidParser());

        $parser->setLink($linkMock->setUrl('github.com'));
        $this->assertFalse($parser->isValidParser());
    }
}
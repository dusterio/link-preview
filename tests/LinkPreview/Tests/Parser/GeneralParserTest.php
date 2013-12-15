<?php

namespace LinkPreview\Tests\Parser;

use LinkPreview\Parser\GeneralParser;

class GeneralParserTest extends \PHPUnit_Framework_TestCase
{
    public function testIsValidParser()
    {
        $parser = new GeneralParser();
        $parser->setLink($this->getLinkMock('http://github.com'));
        $this->assertTrue($parser->isValidParser());

        $parser->setLink($this->getLinkMock('http://trololo'));
        $this->assertFalse($parser->isValidParser());

        $parser->setLink($this->getLinkMock('github.com'));
        $this->assertFalse($parser->isValidParser());
    }

    private function getLinkMock($url)
    {
        $link = $this->getMock('LinkPreview\Model\Link', array('getUrl'));
        $link->expects($this->any())
            ->method('getUrl')
            ->will($this->returnValue($url));

        return $link;
    }
}
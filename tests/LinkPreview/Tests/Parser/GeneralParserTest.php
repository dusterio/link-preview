<?php

namespace LinkPreview\Tests\Parser;

use LinkPreview\Parser\GeneralParser;

class GeneralParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider urlProvider
     * @param string $url
     * @param bool $expectedResult
     */
    public function testIsValidParser($url, $expectedResult)
    {
        $linkMock = $this->getMock('LinkPreview\Model\Link', null);

        $parser = new GeneralParser();
        $parser->setLink($linkMock->setUrl($url));
        self::assertEquals($parser->isValidParser(), $expectedResult);
    }

    /**
     * @return array
     */
    public function urlProvider()
    {
        return [
            ['http://github.com', true],
            ['http://trololo', false],
            ['github.com', false]
        ];
    }
}
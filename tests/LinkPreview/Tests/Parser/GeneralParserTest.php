<?php

namespace Dusterio\LinkPreview\Tests\Parser;

use Dusterio\LinkPreview\Parsers\GeneralParser;

class GeneralParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider urlProvider
     * @param string $url
     * @param bool $expectedResult
     */
    public function testHasParsableLink($url, $expectedResult)
    {
        $linkMock = $this->getMock('Dusterio\LinkPreview\Models\Link', null);

        $parser = new GeneralParser();
        $parser->setLink($linkMock->setUrl($url));
        self::assertEquals($parser->hasParsableLink(), $expectedResult);
    }

    /**
     * @return array
     */
    public function urlProvider()
    {
        return [
            ['http://github.com', true],
            ['http:/trololo', false],
            ['github.com', false]
        ];
    }
}
<?php

namespace Dusterio\LinkPreview\Tests\Parser;

use Dusterio\LinkPreview\Parsers\HtmlParser;
use Dusterio\LinkPreview\Exceptions\MalformedUrlException;

class GeneralParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider urlProvider
     * @param string $url
     * @expectedException Dusterio\LinkPreview\Exceptions\MalformedUrlException
     * @test
     */
    public function html_parser_can_see_if_a_link_is_bogus_and_throw_exception($url)
    {
        $linkMock = $this->getMock('Dusterio\LinkPreview\Models\Link', null, [$url]);

        $parser = new HtmlParser();

        self::setExpectedExceptionFromAnnotation();
    }

    /**
     * @return array
     */
    public function urlProvider()
    {
        return [
            ['http:/trololo'],
            ['github.com']
        ];
    }
}
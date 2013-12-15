<?php

namespace Tests\Reader;

use LinkPreview\Reader\CurlReader;

class CurlReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetOptionsAreSetByDefault()
    {
        $reader = new CurlReader();
        $this->assertNotNull($reader->getOptions());
    }
}
 
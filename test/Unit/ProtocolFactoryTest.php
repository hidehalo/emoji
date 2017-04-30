<?php

use Hidehalo\Emoji\Features\Protocol\HtmlNcr;
use Hidehalo\Emoji\Features\Protocol\Utf8String;
use Hidehalo\Emoji\Features\ProtocolFactory;
use PHPUnit\Framework\TestCase;

class ProtocolFactoryTest extends TestCase
{
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Can not found protocol Nothing
     */
    public function testGenerator()
    {
        $htmlncr = ProtocolFactory::generate(HtmlNcr::class);
        $utf8string = ProtocolFactory::generate(Utf8String::class);
        $this->assertInstanceOf(HtmlNcr::class, $htmlncr);
        $this->assertInstanceOf(Utf8String::class, $utf8string);
        ProtocolFactory::generate('Nothing');
    }
}

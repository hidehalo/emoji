<?php

use PHPUnit\Framework\TestCase;
use Hidehalo\Emoji\Features\ProtocolFactory;
use Hidehalo\Emoji\Features\Protocol\HtmlNcr;
use Hidehalo\Emoji\Features\Protocol\Utf8String;

class ProtocolFactoryTest extends TestCase
{
    public function testGenerator()
    {
        $htmlncr = ProtocolFactory::generate(HtmlNcr::class);
        $utf8string = ProtocolFactory::generate(Utf8String::class);
        $this->assertInstanceOf(HtmlNcr::class, $htmlncr);
        $this->assertInstanceOf(Utf8String::class, $utf8string);
    }
}
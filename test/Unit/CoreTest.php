<?php

use Hidehalo\Emoji\Core;
use Hidehalo\Emoji\Features\Protocol\HtmlNcr;
use Hidehalo\Emoji\Features\Protocol\Utf8String;
use PHPUnit\Framework\TestCase;

class CoreTest extends TestCase
{
    public function setUp()
    {
        $this->raw = 'Hello 😂';
        $this->utf8string = 'Hello [:128514]';
        $this->htmlncr = 'Hello &#128514;';
    }

    public function tearDown()
    {
        unset($this->raw, $this->utf8string, $this->htmlncr);
    }

    private function getUtf8ProtocolCore()
    {
        return new Core(['protocol_name' => Utf8String::class]);
    }

    private function getHtmlNcrProtocolCore()
    {
        return new Core(['protocol_name' => HtmlNcr::class]);
    }

    public function testUtf8StringEncodeAndDecode()
    {
        $core = $this->getUtf8ProtocolCore();
        $ret = $core->encode($this->raw);
        $this->assertEquals($ret, $this->utf8string);
        $ret = $core->decode($ret);
        $this->assertEquals($this->raw, $ret);
    }

    public function testHtmlNcrEncodeAndDecode()
    {
        $core = $this->getHtmlNcrProtocolCore();
        $ret = $core->encode($this->raw);
        $this->assertEquals($ret, $this->htmlncr);
        $ret = $core->decode($ret, ['raw' => true]);
        $this->assertEquals($this->raw, $ret);
        $ret = $core->decode($this->htmlncr, ['raw' => false]);
        $this->assertEquals($this->htmlncr, $ret);
    }

    public function testClean()
    {
        $core = $this->getUtf8ProtocolCore();
        $ret = $core->clean($this->raw);
        $this->assertEquals('Hello ', $ret);
    }

    public function testParse()
    {
        $core = $this->getUtf8ProtocolCore();
        $ret = $core->parse($this->raw);
        $this->assertNotEmpty($ret);
    }
}

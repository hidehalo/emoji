<?php

use Hidehalo\Emoji\Features\UnicodeParser;
use PHPUnit\Framework\TestCase;

class UnicodeParserTest extends TestCase
{
    public function setUp()
    {
        $this->bytesNumber = 4;
        $this->symbol = '😂';
        $this->unicode = 128514;
        $this->bytes = [
            240,
            159,
            152,
            130,
        ];
    }

    public function tearDown()
    {
        unset($this->bytesNumber, $this->symbol, $this->unicode, $this->bytes);
    }

    public function testGetBytesNumber()
    {
        $ret = UnicodeParser::getBytesNumber($this->symbol);
        $this->assertEquals($this->bytesNumber, $ret);
    }

    public function testGetBytes()
    {
        $ret = UnicodeParser::getBytes($this->symbol);
        $this->assertEquals($this->bytes, $ret);
    }

    public function testGetSymbol()
    {
        $ret = UnicodeParser::getSymbol($this->unicode);
        $this->assertEquals($this->symbol, $ret);
    }

    public function testGetUnicode()
    {
        $ret = UnicodeParser::getUnicode($this->symbol, $this->bytesNumber);
        $this->assertEquals($this->unicode, $ret);
    }
}

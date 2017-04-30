<?php

use Hidehalo\Emoji\Features\EmojiParser;
use Hidehalo\Emoji\Unicode\Emoji;
use PHPUnit\Framework\TestCase;

class TestEmojiParser extends TestCase
{
    public function __construct()
    {
        parent::__construct();
        $this->case = new EmojiParser();
    }

    public function testClean()
    {
        $this->assertEquals('Hello', $this->case->clean('Hello'));
        $string = 'Hello ☻';
        $ret = $this->case->clean($string);
        $this->assertEquals($ret, 'Hello ');
    }

    public function testParse()
    {
        $string = 'Hello ☻';
        $ret = $this->case->parse($string);
        $this->assertNotEmpty($ret);
        $this->assertInstanceOf(Emoji::class, $ret[array_rand($ret)]);
        $this->assertEmpty($this->case->parse('Hello'));
    }
}

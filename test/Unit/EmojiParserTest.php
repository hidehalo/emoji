<?php

use PHPUnit\Framework\TestCase;
use Hidehalo\Emoji\Unicode\Emoji;
use Hidehalo\Emoji\Features\EmojiParser;

class TestEmojiParser extends TestCase
{
    public function __construct()
    {
        parent::__construct();
        $this->case = new EmojiParser();
    }

    public function testClean()
    {
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
    }
}
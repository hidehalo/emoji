<?php

use Hidehalo\Emoji\Features\EmojiParser;
use PHPUnit\Framework\TestCase;

class TestEmojiParser extends TestCase
{
    public function testClean()
    {
        $parser = new EmojiParser();
        $string = 'Hello ☻';
        $result = $parser->clean($string);
        $this->assertEquals($result, 'Hello ');
    }

    public function testUtf8StringEncodeAndDecode()
    {
        $parser = new EmojiParser();
        $string = 'Hello ☻';
        $result = $parser->utf8stringEncode($string);
        $this->assertEquals($result, 'Hello [:9787]');
        $result = $parser->utf8StringDecode($result);
        $this->assertEquals($string, $result);
    }
}
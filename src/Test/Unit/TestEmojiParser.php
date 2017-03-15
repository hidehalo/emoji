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
}
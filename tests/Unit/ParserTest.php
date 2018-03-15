<?php

namespace Hidehalo\Emoji\Tests;

use Hidehalo\Emoji\Parser;

use PHPUnit\Framework\TestCase;
use Hidehalo\Emoji\Unicode\Emoji;
use Hidehalo\Emoji\Tests\TestSampleTrait;

class ParserTest extends TestCase
{
    use TestSampleTrait;
    
    public function __construct()
    {
        parent::__construct();
        $this->case = new Parser();
    }
   
    public function testParse()
    {
        $samples = $this->sampleProvider();
        foreach ($samples as $sample) {
            $string = "Hello $sample";
            $ret = $this->case->parse($string);
            $expected = [ $sample ];
            // NOTE: Have fun with non-fully-qualified emoji zwj sequence
            if ($ret != $expected) {
                $fix = "";
                foreach (utf8_cursor($expected[0]) as $byte) {
                    $codepoint = utf8_to_cop($byte);
                    if ($codepoint == 0xfe0f || $codepoint < 0x80) {
                        continue;
                    }
                    $fix .= $byte;
                }
                $expected = [ $fix ];
                $tmp = implode('', $ret);
                $fix = "";
                foreach (utf8_cursor($tmp) as $byte) {
                    $codepoint = utf8_to_cop($byte);
                    if ($codepoint == 0xfe0f || $codepoint < 0x80) {
                        continue;
                    }
                    $fix .= $byte;
                }
                $ret = [ $fix ];
            }
            $this->assertSame($expected, $ret);
        }
    }
}

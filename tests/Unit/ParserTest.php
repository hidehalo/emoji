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
            $string = "Hello $sample and $sample";
            $ret = $this->case->parse($string);
            $this->assertSame($sample.$sample, $ret);
        }
    }
}

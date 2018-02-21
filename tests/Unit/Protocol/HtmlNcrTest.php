<?php

namespace Hidehalo\Emoji\Tests\Protocol;

use Hidehalo\Emoji\Protocol\HtmlNcr;
use PHPUnit\Framework\TestCase;

class HtmlNcrTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();
        $this->case = new HtmlNcr();
        $this->encoded = '&#128514;';
        $this->decoded = '😂';
    }

    public function testEncode()
    {
        $ret = $this->case->encode($this->decoded);
        $this->assertSame($this->encoded, $ret);        
    }

    public function testDecode()
    {
        $ret = $this->case->decode($this->encoded);
        $this->assertSame($this->decoded, $ret);
    }

}

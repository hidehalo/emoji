<?php

namespace Hidehalo\Emoji\Tests\Protocol;

use PHPUnit\Framework\TestCase;
use Hidehalo\Emoji\Protocol\Filter;
use Hidehalo\Emoji\Protocol\HtmlNcr;

class FilterTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();
        $this->case = new Filter();
    }

    public function testEncode()
    {
        $ret = $this->case->encode('😂');
        $this->assertSame('', $ret);        
    }

    public function testDecode()
    {
        $ret = $this->case->decode('😂');
        $this->assertSame('', $ret);
    }
}

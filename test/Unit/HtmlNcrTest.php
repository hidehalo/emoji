<?php

use Hidehalo\Emoji\Features\Protocol\HtmlNcr;
use PHPUnit\Framework\TestCase;

class HtmlNcrTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();
        $this->case = new HtmlNcr();

    }

    public function setUp()
    {
        $this->encoded = 'Hello &9787;';
        $this->decoded = 'Hello ☻';
    }

    public function tearDown()
    {
        unset($this->encoded,$this->decoded);
    }


    public function testGetPattern()
    {
        $ret = $this->case->getPattern();
        $this->assertEquals('/&\d+;/', $ret);
    }
}
<?php

use Hidehalo\Emoji\Features\Protocol\Utf8String;
use PHPUnit\Framework\TestCase;

class Utf8StringTest extends TestCase
{

    public function __construct()
    {
        parent::__construct();
        $this->case = new Utf8String();

    }

    public function setUp()
    {
        $this->encoded = 'Hello [:9787]';
        $this->decoded = 'Hello ☻';
    }

    public function tearDown()
    {
        unset($this->encoded,$this->decoded);
    }

    public function testGetPattern()
    {
        $ret = $this->case->getPattern();
        $this->assertEquals('/\[\:\d+\]/', $ret);
    }
}
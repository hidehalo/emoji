<?php

namespace Hidehalo\Emoji\Tests\Protocol;

use PHPUnit\Framework\TestCase;
use Hidehalo\Emoji\Protocol\Utf8String;
use Hidehalo\Emoji\Tests\TestSampleTrait;

class Utf8StringTest extends TestCase
{
    use TestSampleTrait;
    
    public function __construct()
    {
        parent::__construct();
        $this->case = new Utf8String();
    }
    
    public function testEncodeAndDecode()
    {
        $samples = $this->sampleProvider();
        foreach ($samples as $sample) {
            $full = '';
            foreach (utf8_cursor($sample) as $char) {
                $encoded = $this->case->encode($char);
                $decoded = $this->case->decode($encoded);
                $full .= $decoded;
                $this->assertSame($char, $decoded);
            }
            $this->assertSame($sample, $full);
        }
    }
}

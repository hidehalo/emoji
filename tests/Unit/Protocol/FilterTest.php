<?php

namespace Hidehalo\Emoji\Tests\Protocol;

use PHPUnit\Framework\TestCase;
use Hidehalo\Emoji\Protocol\Filter;
use Hidehalo\Emoji\Protocol\HtmlNcr;
use Hidehalo\Emoji\Tests\TestSampleTrait;

class FilterTest extends TestCase
{
    use TestSampleTrait;
    
    public function __construct()
    {
        parent::__construct();
        $this->case = new Filter();
    }

    public function testEncodeAndDecode()
    {
        $samples = $this->sampleProvider();
        foreach ($samples as $sample) {
            $encoded = $this->case->encode($sample);
            $decoded = $this->case->decode($encoded);
            $this->assertSame($encoded, $decoded);
            $this->assertSame('', $encoded);
        }
    }
}

<?php

namespace Hidehalo\Emoji\Tests;

use Hidehalo\Emoji\Parser;
use Hidehalo\Emoji\Unicode\Emoji;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();
        $this->case = new Parser();
    }

    /**
     * @dataProvider sampleProvider
     */
    public function testParse()
    {
        $samples = $this->sampleProvider()[0][0];
        foreach ($samples as $sample) {
            $string = "Hello $sample";
            $ret = $this->case->parse($string);
            $full = '';
            foreach ($ret[0] as $char) {
                $full .= $char;
            }
            $this->assertSame($sample, $full);
        }
    }

    public function sampleProvider()
    {
        $path = __DIR__.'/../../data/emoji-test.txt';
        $samples = [];
        $this->read($path, $samples);
        $size = count($samples);
        if ($size > 0) {              
            $samples = array_map(function ($elm) {
                $codepoints = explode(' ', $elm);
                $str = '';
                foreach ($codepoints as $codepoint) {
                    $str .= unicode(hexdec($codepoint));
                }

                return $str;
            }, $samples);
        }

        return [
            [ $samples ]
        ];
    }

    private function read($filename, &$ret)
    {
        $file = fopen($filename, 'rb');
        if (!$file) {
            return ;
        }
    
        while (($line = fgets($file)) !== false) {
            if ($line[0] == '#') {
                continue;
            } elseif (strlen(trim($line) <= 0)) {
                continue;
            }
            $pos = strpos($line, ';');
            $codepoints = trim(substr($line, 0, $pos));
            $ret[md5($codepoints)] = $codepoints;
        }
        $ret = array_values($ret);
    
        fclose($file);
    }
}

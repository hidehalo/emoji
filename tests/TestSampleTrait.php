<?php

namespace Hidehalo\Emoji\Tests;

trait TestSampleTrait
{
    public function sampleProvider()
    {
        $path = __DIR__.'/../data/emoji-test.txt';
        $samples = [];
        $this->read($path, $samples);
        $size = count($samples);
        if ($size > 0) {
            $samples = array_map(function ($elm) {
                $codepoints = explode(' ', $elm);
                $str = '';
                foreach ($codepoints as $codepoint) {
                    $str .= cop_to_utf8(hexdec($codepoint));
                }

                return $str;
            }, $samples);
        }

        return $samples;
    }

    public function read($filename, &$ret)
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
<?php

namespace Hidehalo\Emoji\Protocol;

class Utf8String implements ProtocolInterface
{
    use PatternAwareTrait;
    
    protected $format = '[:%d]';
    protected $pattern = '/\[\:\d+\]/';

    public function encode($contents)
    {
        $codepoint = codepoint($contents);
        $format = $this->getFormat();
        $encoded = sprintf($format, $codepoint);

        return $encoded;
    }

    public function decode($contents)
    {
        $codepoint = (int) substr($contents, 2, -1);
        $decoded = unicode($codepoint);

        return $decoded;
    }
}

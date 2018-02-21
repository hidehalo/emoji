<?php

namespace Hidehalo\Emoji\Protocol;

class HtmlNcr implements ProtocolInterface
{
    use PatternAwareTrait;
    
    protected $format = '&#%d;';
    protected $pattern = '/&#\d+;/';

    public function encode($contents)
    {
        $unicode = codepoint($contents);
        $format = $this->getFormat();
        $encoded = sprintf($format, $unicode);

        return $encoded;
    }

    public function decode($contents)
    {
        $unicode = (int) substr($contents, 2, -1);
        $decoded = unicode($unicode);

        return $decoded;
    }
}

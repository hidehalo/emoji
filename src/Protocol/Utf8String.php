<?php

namespace Hidehalo\Emoji\Protocol;

class Utf8String implements ProtocolInterface
{
    use PatternAwareTrait;
    
    protected $format = '[:%d]';
    protected $pattern = '/\[\:\d+\]/';

    /**
     * @inheritDoc
     */
    public function encode($contents)
    {
        $codepoint = utf8_to_cop($contents);
        $format = $this->getFormat();
        $encoded = sprintf($format, $codepoint);

        return $encoded;
    }

    /**
     * @inheritDoc
     */
    public function decode($contents)
    {
        $codepoint = (int) substr($contents, 2, -1);
        $decoded = cop_to_utf8($codepoint);

        return $decoded;
    }
}

<?php

namespace Hidehalo\Emoji\Protocol;

class HtmlNcr implements ProtocolInterface
{
    use PatternAwareTrait;
    
    protected $format = '&#%d;';
    protected $pattern = '/&#\d+;/';

    /**
     * @inheritDoc
     */
    public function encode($contents)
    {
        $unicode = utf8_to_cop($contents);
        $format = $this->getFormat();
        $encoded = sprintf($format, $unicode);

        return $encoded;
    }

    /**
     * @inheritDoc
     */
    public function decode($contents)
    {
        $unicode = (int) substr($contents, 2, -1);
        $decoded = cop_to_utf8($unicode);

        return $decoded;
    }
}

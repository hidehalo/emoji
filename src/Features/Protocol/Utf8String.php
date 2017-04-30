<?php
/**
 * Created by PhpStorm.
 * User: tian
 * Date: 2017/3/30
 * Time: 11:23.
 */

namespace Hidehalo\Emoji\Features\Protocol;

use Hidehalo\Emoji\Features\UnicodeParser;

class Utf8String implements ProtocolInterface
{
    protected $format = '[:%d]';
    protected $pattern = '/\[\:\d+\]/';

    public function encode($contents, array $options = [])
    {
        $bytesNumber = UnicodeParser::getBytesNumber($contents);
        $unicode = UnicodeParser::getUnicode($contents, $bytesNumber);
        $format = $this->getFormat();
        $encoded = sprintf($format, $unicode);

        return $encoded;
    }

    public function decode($contents, array $options = [])
    {
        $unicode = (int) substr($contents, 2, -1);
        $decoded = UnicodeParser::getSymbol($unicode);

        return $decoded;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    protected function getFormat()
    {
        return $this->format;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: tian
 * Date: 2017/3/30
 * Time: 11:22
 */

namespace Hidehalo\Emoji\Features\Protocol;

use Hidehalo\Emoji\Features\UnicodeParser;

class HtmlNcr extends Utf8String implements ProtocolInterface
{
    protected $format = "&%d;";
    protected $pattern = '/&\d+;/';

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
        if (isset($options['raw']) && $options['raw'] == true) {
            $unicode = (int) substr($contents,1,-1);
            $decoded = UnicodeParser::getSymbol($unicode);
        } else {
            $decoded = $contents;
        }

        return $decoded;
    }
}
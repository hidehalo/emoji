<?php
/**
 * Created by PhpStorm.
 * User: TianChen
 * Date: 17/1/7
 * Time: 15:59
 */

namespace Hidehalo\Emoji\Features;


use Hidehalo\Emoji\Unicode\Emoji;

class EmojiParser
{
    //http://apps.timwhitlock.info/emoji/tables/unicode
    protected $maps = [
        [0x0080,0x02AF],
        [0x0300,0x03FF],
        [0x0600,0x06FF],
        [0x0C00,0x0C7F],
        [0x1DC0,0x1DFF],
        [0x1E00,0x1EFF],
        [0x2000,0x209F],
        [0x20D0,0x214F],
        [0x2190,0x23FF],
        [0x2460,0x25FF],
        [0x2600,0x27EF],
        [0x2900,0x29FF],
        [0x2B00,0x2BFF],
        [0x2C60,0x2C7F],
        [0x2E00,0x2E7F],
        [0x3000,0x303F],
        [0xA490,0xA4CF],
        [0xE000,0xF8FF],
        [0xFE00,0xFE0F],
        [0xFE30,0xFE4F],
        [0x1F000,0x1F02F],
        [0x1F0A0,0x1F0FF],
        [0x1F100,0x1F64F],
        [0x1F680,0x1F6FF],
        [0x1F910,0x1F918],
        [0x1F980,0x1F9C0],
    ];
    protected $pattern;

    function buildRegex($maps = [])
    {
        if (!$maps) {
            $maps = $this->maps;
        }
        $pattern = '';
        foreach ($maps as $range) {
            $min = $range[0];
            $max = $range[1];
            $pattern .=  $this->getSymbol($min).'-'.$this->getSymbol($max);
        }
        $this->pattern = '/['.$pattern.']/u';

        return $this;
    }

    /**
     * parse string to offset and emoji object map
     * @param $string
     * @return array [offset => emoji object]
     */
    function parse($string)
    {
        if (!$this->pattern) {
           return [];
        }
        $matchesNo = preg_match_all($this->pattern,$string,$matches,PREG_OFFSET_CAPTURE);
        if ($matchesNo>0 && $matches) {
            foreach ($matches as $emojis) {
                foreach($emojis as $emoji){
                    $symbol = $emoji[0];
                    $offset = $emoji[1];
                    $bytes = $this->getBytes($symbol);
                    $bytesNumber = $this->getBytesNumber($symbol);
                    $unicode = $this->getUnicode($symbol,$bytesNumber);
                    $result[$offset] = new Emoji($symbol,$bytes,$unicode,$bytesNumber);
                }
            }

            return $result;
        }

        return [];
    }

    function clean($string)
    {
        if (!$this->pattern) {
            return $string;
        }
        $count = 0;
        $result = preg_replace($this->pattern,'',$string,-1,$count);

        return $count>0?$result:$string;
    }

    function replace($string,callable $callback)
    {
        if (!$this->pattern) {
            return $string;
        }
        $count = 0;
        $result = preg_replace_callback($this->pattern,$callback,$string,-1,$count);

        return $count>0?$result:$string;
    }

    /**
     * get native emoji symbol by unicode
     * @param $unicode
     * @return string $symbol
     */
    protected function getSymbol($unicode)
    {
        $symbol = iconv('UCS-4LE', 'UTF-8', pack('V', $unicode));

        return $symbol;
    }

    /**
     * character of unicode symbol convert to unicode value
     * @param string $symbol
     * @param integer $bytes
     * @return integer $ascii
     */
    protected function getUnicode($symbol,$bytes = 1)
    {
        $offset = 0;
        $highChar = substr($symbol, $offset ,1);
        $ascii = ord($highChar);
        if ($bytes > 1) {
            $code = ($ascii) & (2 ** (7 - $bytes) - 1);
            for ($i = 1;$i<$bytes;$i++) {
                $char = substr($symbol, $offset + $i, 1);
                $code =  ($code << 6) | (ord($char) & 0x3f);
            }
            $ascii = $code;
        }

        return $ascii;
    }

    /**
     * get Unicode symbol bytes number
     * @param string $symbol
     * @return integer $bytesNumber
     */
    protected function getBytesNumber($symbol)
    {
        $ascii = ord($symbol);
        $bytesNumber = 1;
        if ($ascii > 0x7f) {
            switch ($ascii&0xf0) {
                case 0xfd:
                    $bytesNumber = 6;
                    break;
                case 0xf8:
                    $bytesNumber = 5;
                    break;
                case 0xf0:
                    $bytesNumber = 4;
                    break;
                case 0xe0:
                    $bytesNumber = 3;
                    break;
                case 0xd1:
                case 0xd0:
                    $bytesNumber = 2;
                    break;
            }
        }

        return $bytesNumber;
    }

    /**
     * @param $symbol
     */
    protected function getBytes($symbol)
    {
        $bytesNumber = $this->getBytesNumber($symbol);
        $bytes = [];
        for ($i=0; $i<$bytesNumber; $i++) {
            $bytes[] = ord(substr($symbol,$i,1));
        }

        return $bytes;
    }

}
<?php

namespace Hidehalo\Emoji\Features;

use Hidehalo\Emoji\Unicode\Emoji;
use Hidehalo\Emoji\Features\Protocol\Utf8String;
use Hidehalo\Emoji\Features\Protocol\ProtocolInterface;

class EmojiParser extends UnicodeParser
{
    //http://apps.timwhitlock.info/emoji/tables/unicode
    private $maps = [
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
        [0x1F910,0x1F96B],
        [0x1F980,0x1F9E0],
    ];
    /**
     * @var string $pattern;
     */
    protected $pattern;

    public function __construct(array $config = [])
    {
        $this->pattern = $this->buildRegex($this->maps);
    }

    /**
     * parse string to offset and emoji object map
     * @param $string
     * @return array [offset => emoji object]
     */
    public function parse($string)
    {
        // @codeCoverageIgnoreStart
        if (!$this->pattern) {
           return [];
        }
        // @codeCoverageIgnoreEnd
        $matchesNo = preg_match_all($this->pattern,$string,$matches,PREG_OFFSET_CAPTURE);
        if ($matchesNo>0 && $matches) {
            foreach ($matches as $emojis) {
                foreach ($emojis as $emoji) {
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

    public function clean($string)
    {
        //@codeCoverageIgnoreStart
        if (!$this->pattern) {
            return $string;
        }
        //@codeCoverageIgnoreEnd
        $count = 0;
        $result = preg_replace($this->pattern,'',$string,-1,$count);

        return $count>0?$result:$string;
    }

    public function replace($string,callable $callback, $pattern = '')
    {
        if (!$pattern) {
            $pattern = $this->pattern;
        }
        $count = 0;
        $result = preg_replace_callback($pattern,$callback,$string,-1,$count);

        return $count>0 ? $result : $string;
    }

    private function buildRegex($maps)
    {
        $pattern = '';
        if ($maps) {
            foreach ($maps as $range) {
                $min = $range[0];
                $max = $range[1];
                $pattern .= $this->getSymbol($min) . '-' . $this->getSymbol($max);
            }
            $pattern = '/['.$pattern.']/u';
        }

        return $pattern;
    }
}
<?php

namespace Hidehalo\Emoji\Features;

use Hidehalo\Emoji\Unicode\Emoji;

class EmojiParser extends UnicodeParser
{
    /* @link http://unicode.org/emoji/charts/full-emoji-list.html */
    private $maps = [
        [0x00A9, 0x00AE],
        [0x200D, 0x2B55],
        [0x3030, 0x303D],
        [0x3297, 0x3299],
        [0xFE0F, 0xFE0F],
        [0xFE30, 0xFE4F],
        [0x1F004, 0x1F9E6],
        [0xE0062, 0xE007F],
    ];
    /**
     * @var string;
     */
    protected $pattern;

    public function __construct(array $config = [])
    {
        $this->pattern = $this->buildRegex($this->maps);
    }

    /**
     * parse string to offset and emoji object map.
     *
     * @param $string
     *
     * @return array [offset => emoji object]
     */
    public function parse($string)
    {
        // @codeCoverageIgnoreStart
        if (!$this->pattern) {
            return [];
        }
        // @codeCoverageIgnoreEnd
        $matchesNo = preg_match_all($this->pattern, $string, $matches, PREG_OFFSET_CAPTURE);
        if ($matchesNo > 0 && $matches) {
            foreach ($matches as $emojis) {
                foreach ($emojis as $emoji) {
                    $symbol = $emoji[0];
                    $offset = $emoji[1];
                    $bytes = $this->getBytes($symbol);
                    $bytesNumber = $this->getBytesNumber($symbol);
                    $unicode = $this->getUnicode($symbol, $bytesNumber);
                    $result[$offset] = new Emoji($symbol, $bytes, $unicode, $bytesNumber);
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
        $result = preg_replace($this->pattern, '', $string, -1, $count);

        return $count > 0 ? $result : $string;
    }

    public function replace($string, callable $callback, $pattern = '')
    {
        if (!$pattern) {
            $pattern = $this->pattern;
        }
        $count = 0;
        $result = preg_replace_callback($pattern, $callback, $string, -1, $count);

        return $count > 0 ? $result : $string;
    }

    private function buildRegex($maps)
    {
        $pattern = '';
        if ($maps) {
            foreach ($maps as $range) {
                $min = $range[0];
                $max = $range[1];
                $pattern .= $this->getSymbol($min).'-'.$this->getSymbol($max);
            }
            $pattern = '/['.$pattern.']/u';
        }

        return $pattern;
    }
}

<?php

namespace Hidehalo\Emoji\Features;

use League\Csv\Reader;
use Hidehalo\Emoji\Unicode\Emoji;

class EmojiParser extends UnicodeParser
{
    /* @link http://unicode.org/emoji/charts/full-emoji-list.html */
    private $maps = [
        0xFE0F,
        0x20E3,
        [0xE0062, 0xE007F],
    ];
 
    protected $pattern;

    public function __construct(array $config = [])
    {
        $this->maps = array_merge($this->maps, $this->buildMapFromCsv());
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
                if (is_array($range)) {
                    $min = $range[0];
                    $max = $range[1];
                } else {
                    $min = $max = $range;
                }
                $pattern .= $this->getSymbol($min).'-'.$this->getSymbol($max);
            }
            $pattern = '/['.$pattern.']/u';
        }

        return $pattern;
    }

    private function buildMapFromCsv()
    {
        $reader = Reader::createFromPath(__DIR__.'/../../data/emoji.csv');
        $result = $reader->fetchAssoc(['codepoints']);
        $maps = [];
        foreach ($result as $row) {
            $codepoint = trim($row['codepoints']);
            if ($codepoint == 'codepoints')
                continue;
            if ($this->isRange($codepoint)) {
                list($min, $max) = explode('..',$codepoint);
                $maps[] = [hexdec("0x$min"), hexdec("0x$max")];
            } else {
                $maps[] = hexdec("0x$codepoint");
            }
        }

        return $maps;
    }

    private function isRange($codepoints)
    {
        return strpos($codepoints, '..');
    }
}

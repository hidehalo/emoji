<?php

namespace Hidehalo\Emoji;

use RuntimeException;

/**
 * @codeCoverageIgnore
 */
class RegexBuilder
{
    public function __construct($dataPath)
    {
        if (!file_exists($dataPath)) {
            throw new RuntimeException("File $dataPath is not exists");
        }
        $this->dataPath = $dataPath;
    }

    /**
     * Complie emoji and emoji sequences regex pattern
     *
     * @return string
     */
    public function complie()
    {
        $data = $this->load();
        $varPattern = $this->complieEmojiSequences($data['emoji-variation-sequences']);
        $zwjPattern = $this->complieEmojiSequences($data['emoji-zwj-sequences']);
        $seqPattern = $this->complieEmojiSequences($data['emoji-sequences']);
        $emojiPattern = $this->complieEmoji($data['emoji-data']);
        $pattern = "/$seqPattern|$zwjPattern|$varPattern|$emojiPattern/mu";

        return $pattern;
    }

    /**
     * Complie emoji regex pattern
     *
     * @param array $emojis
     * @return string
     */
    private function complieEmoji($emojis)
    {
        $pattern = '';
        $flag = '|';
        foreach ($emojis as $codepoints) {
            $slice = cop_to_utf8(hexdec($codepoints));                      
            if (strpos($codepoints, '..') !== false) {
                list($codepointA, $codepointB) = explode('..', $codepoints);
                if (hexdec($codepointA) < 0x80) {
                    continue;
                }
                $slice = '['.cop_to_utf8(hexdec($codepointA)).'-'.cop_to_utf8(hexdec($codepointB)).']';
            } elseif (hexdec($codepoints) < 0x80) {
                continue;
            }
            $pattern .= ($flag.$slice);
        }

        return trim($pattern, '|');
    }

    /**
     * Complie emoji sequences regex pattern
     *
     * @param array $seqences
     * @return string
     */
    private function complieEmojiSequences($seqences)
    {
        $pattern = '';
        $flag = '|';
        foreach ($seqences as $seq) {
            $slice = '';
            $codepoints = explode(' ', $seq);
            foreach ($codepoints as $codepoint) {
                $tmp = cop_to_utf8(hexdec($codepoint));
                $slice .= preg_quote($tmp, '\+*?[^]$(){}=!<>|:-#');
            }
            $pattern .= ($flag.$slice);
        }

        return trim($pattern, '|');
    }

    /**
     * Load emoji data
     *
     * @return void
     */
    private function load()
    {
        return json_decode(file_get_contents($this->dataPath), 1);
    }
}
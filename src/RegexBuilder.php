<?php

namespace Hidehalo\Emoji;

class RegexBuilder
{
    public function __construct($dataPath)
    {
        if (!file_exists($dataPath)) {
            //TODO: handle error
        }
        $this->dataPath = $dataPath;
    }

    public function complie()
    {
        $data = $this->load();
        $varPattern = $this->complieEmojiSequences($data['emoji-variation-sequences']);
        $zwjPattern = $this->complieEmojiSequences($data['emoji-zwj-sequences']);
        $seqPattern = $this->complieEmojiSequences($data['emoji-sequences']);
        $emojiPattern = $this->complieEmoji($data['emoji-data']);
        $pattern = "/[$emojiPattern|$seqPattern|$zwjPattern|$varPattern]/muxX";
        // $pattern = "/[$seqPattern]/muxX";
        

        return $pattern;
    }

    private function complieEmoji($emojis)
    {
        $pattern = '';
        $flag = '|';
        foreach ($emojis as $codepoints) {
            $slice = unicode(hexdec($codepoints));                      
            if (strpos($codepoints, '..') !== false) {
                list($codepointA, $codepointB) = explode('..', $codepoints);
                if (hexdec($codepointA) < 0x80) {
                    continue;
                }
                $slice = unicode(hexdec($codepointA)).'-'.unicode(hexdec($codepointB));;
            } elseif (hexdec($codepoints) < 0x80) {
                continue;
            }

            $pattern .= ($flag.$slice);
        }

        return trim($pattern, '|');
    }

    private function complieEmojiSequences($seqences)
    {
        $pattern = '';
        $flag = '|';
        foreach ($seqences as $seq) {
            $slice = '';
            $codepoints = explode(' ', $seq);
            foreach ($codepoints as $codepoint) {
                $tmp = unicode(hexdec($codepoint));
                $slice .= preg_quote($tmp, '\+*?[^]$(){}=!<>|:-#');
            }
            $pattern .= $flag.$slice;
        }

        return trim($pattern, '|');
    }

    private function load()
    {
        return json_decode(file_get_contents($this->dataPath), 1);
    }
}
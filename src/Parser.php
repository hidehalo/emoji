<?php

namespace Hidehalo\Emoji;

use Hidehalo\Emoji\Protocol\Utf8String;

class Parser
{
    protected $pattern;

    public function __construct()
    {
        $this->pattern = (new RegexBuilder(__DIR__.'/../data/emoji.cache'))->complie();
    }

    public function parse($string)
    {
        $ret = preg_match_all($this->pattern, $string, $matches);
       
        return $ret? $matches: false;
    }

    public function getPattern()
    {
        return $this->pattern;
    }
}
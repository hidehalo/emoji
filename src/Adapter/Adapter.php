<?php
namespace Hidehalo\String\Emoji;
require_once __DIR__."/../Detector/Detector.php";
require_once __DIR__."/../Unicode/EmojiUnicode.php";
use Hidehalo\String\Emoji\Detector;
use Hidehalo\String\Emoji\EmojiUnicode;
abstract class Adapter implements EmojiUnicode,Detector
{
    protected $pattern;

    abstract protected function entities($string);  
    abstract protected function replace($text,$format);
    
    public function getPattern()
    {
        return $this->pattern;
    }
}
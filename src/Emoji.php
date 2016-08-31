<?php 
require_once "Detector.php";
require_once "EmojiUnicode.php";
class Emoji implements Detector,EmojiUnicode
{
    private $adpter;
    public function __construct(Adapter $adpter)
    {
        $this->adpter = $adpter;
    }
    
    public function detect($text)
    {
        $emojis=false;
        $pattern = $this->adpter->getPattern();
        preg_match_all($pattern,$text,$emojis);
        return $emojis;
    }
    
    public function replace($text,$format)
    {
        if(!$format) return $text;
        try{
            switch($format){
                case 'ncrhex':$callback = $this->ncrhex();break;
                case 'ncrdec':$callback = $this->ncrdec();break;
                case 'symbol':$callback = $this->symbol();break;
                case 'unicode':$callback = $this->unicode();break;
                case 'clean':$callback = $this->clean();break;
                default:$callback = null;
            }
            if(!$callback) return $text;//or throw exception
            $pattern = $this->adpter->getPattern();
            $replace = preg_replace_callback($pattern,$callback,$text);
        }catch(Exception $e){
            return $text;
        }
        return $replace;
    }
}
<?php
namespace Hidehalo\String\Emoji;
require_once "Adapter.php";
use Hidehalo\String\Emoji\Adapter;
class HtmlAdapter extends Adapter
{    
    //Inheritance Adapter
    //protected $pattern;
    
    //replace to unicode hex value
    private function hex()
    {
        return function($emojis) {
            if($emojis){
                foreach($emojis as &$match) {    
                }
                return $match;
            }
        };
    }
    
    //get ascii and Chinese only
    private function clean()
    {
        return function($emojis) {
            if($emojis){
                foreach($emojis as &$match) {    
                    $match = '';
                }
                return $match;
            }
        };
    }
    
    //replace unicode dec value
    private function dec()
    {
        return function($emojis){
            if($emojis)
                foreach($emojis as &$match){
                    $match= $this->entities($match);       
                }
            return $match;
        };
    }
    
    //extend mbstring convert unicode value to char
    protected function mbunichr($u)
    {
        $unichar = mb_convert_encoding('&#'.$u.';','UTF-8','HTML-ENTITIES');
        return $unichar;
    }
    
    //implements EmojiUnicode
    public function unichr($i) 
    {
        return iconv('UCS-4LE', 'UTF-8', pack('V', $i));
    }
    
    //implements EmojiUnicode
    // source - http://php.net/manual/en/function.ord.php#109812
    public function ordutf8($string, &$offset) 
    {
        $code = ord(substr($string, $offset,1));
        if ($code >= 128) {        //otherwise 0xxxxxxx
            if ($code < 224) $bytesnumber = 2;                //110xxxxx
            else if ($code < 240) $bytesnumber = 3;        //1110xxxx
            else if ($code < 248) $bytesnumber = 4;    //11110xxx
            $codetemp = $code - 192 - ($bytesnumber > 2 ? 32 : 0) - ($bytesnumber > 3 ? 16 : 0);
            for ($i = 2; $i <= $bytesnumber; $i++) {
                $offset ++;
                $code2 = ord(substr($string, $offset, 1)) - 128;        //10xxxxxx
                $codetemp = $codetemp*64 + $code2;
            }
            $code = $codetemp;
        }
        $offset += 1;
        if ($offset >= strlen($string)) $offset = -1;
        return $code;
    }
    
    //implements EmojiUnicode
    public function entities( $string )
    {
        $stringBuilder = "";
        $offset = 0;
        if ( empty( $string ) ) {
            return "";
        }
        while ( $offset >= 0 ) {
            $decValue = $this->ordutf8( $string, $offset );
            $char = $this->unichr($decValue);
            $htmlEntited = htmlentities( $char );
            if( $char != $htmlEntited ){
                $stringBuilder .= $htmlEntited;
            } elseif( $decValue >= 128 ){
                $stringBuilder .= "&#" . $decValue . ";";
            } else {
                $stringBuilder .= $char;
            }
        }
        return $stringBuilder;
    }
    
    public function __construct()
    {
        //http://apps.timwhitlock.info/emoji/tables/unicode
        $this->pattern ='/['.
            $this->unichr(0x0080).'-'.$this->unichr(0x02AF).
            $this->unichr(0x0300).'-'.$this->unichr(0x03FF).
            $this->unichr(0x0600).'-'.$this->unichr(0x06FF).
            $this->unichr(0x0C00).'-'.$this->unichr(0x0C7F).
            $this->unichr(0x1DC0).'-'.$this->unichr(0x1DFF).
            $this->unichr(0x1E00).'-'.$this->unichr(0x1EFF).
            $this->unichr(0x2000).'-'.$this->unichr(0x209F).
            $this->unichr(0x20D0).'-'.$this->unichr(0x214F).
            $this->unichr(0x2190).'-'.$this->unichr(0x23FF).
            $this->unichr(0x2460).'-'.$this->unichr(0x25FF).
            $this->unichr(0x2600).'-'.$this->unichr(0x27EF).
            $this->unichr(0x2900).'-'.$this->unichr(0x29FF).
            $this->unichr(0x2B00).'-'.$this->unichr(0x2BFF).
            $this->unichr(0x2C60).'-'.$this->unichr(0x2C7F).
            $this->unichr(0x2E00).'-'.$this->unichr(0x2E7F).
            $this->unichr(0x3000).'-'.$this->unichr(0x303F).
            $this->unichr(0xA490).'-'.$this->unichr(0xA4CF).
            $this->unichr(0xE000).'-'.$this->unichr(0xF8FF).
            $this->unichr(0xFE00).'-'.$this->unichr(0xFE0F).
            $this->unichr(0xFE30).'-'.$this->unichr(0xFE4F).
            $this->unichr(0x1F000).'-'.$this->unichr(0x1F02F).
            $this->unichr(0x1F0A0).'-'.$this->unichr(0x1F0FF).
            $this->unichr(0x1F100).'-'.$this->unichr(0x1F64F).
            $this->unichr(0x1F680).'-'.$this->unichr(0x1F6FF).
            $this->unichr(0x1F910).'-'.$this->unichr(0x1F918).
            $this->unichr(0x1F980).'-'.$this->unichr(0x1F9C0).
        ']/u';
    }
    
    //implements Detector
    public function detect($text)
    {
        $emojis=false;
        $pattern = $this->getPattern();
        preg_match_all($pattern,$text,$emojis);
        return $emojis;
    }
    
    //implements Adapter
    public function replace($text,$handler)
    {
        if(!$handler) return $text;
        try{
            switch($handler){
                case 'hex':$callback = $this->hex();break;
                case 'dec':$callback = $this->dec();break;
                case 'clean':$callback = $this->clean();break;
                default:$callback = null;
            }
            if(!$callback) return $text;//or throw exception
            $pattern = $this->getPattern();
            $replace = preg_replace_callback($pattern,$callback,$text);
        }catch(Exception $e){
            return $text;
        }
        return $replace;
    }
 
}
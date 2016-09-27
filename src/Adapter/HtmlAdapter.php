<?php
require_once "Adapter.php";
class HtmlAdpater extends Adapter
{    
    protected $pattern;
    public function __construct()
    {
        //http://apps.timwhitlock.info/emoji/tables/unicode
//        1.Emoticons( 1F601 - 1F64F )
//        2. Dingbats ( 2702 - 27B0 )
//        3. Transport and map symbols ( 1F680 - 1F6C0 )
//        4. Enclosed characters ( 24C2 - 1F251 )
//        5. Uncategorized
        $this->pattern ='/['.
            $this->unichr(0x1F600).'-'.$this->unichr(0x1F64F).
            $this->unichr(0x2700).'-'.$this->unichr(0x27BF).
            $this->unichr(0x1F680).'-'.$this->unichr(0x1F6FF).
            $this->unichr(0x2460).'-'.$this->unichr(0x1F251).
            $this->unichr(0x1F100).'-'.$this->unichr(0x1F1FF).
            $this->unichr(0x1F300).'-'.$this->unichr(0x1F5FF).
            $this->unichr(0xE000).'-'.$this->unichr(0xF8FF).
        ']/u';
    }
    // source - http://php.net/manual/en/function.ord.php#109812
    protected function ordutf8($string, &$offset) 
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
    
    protected function entities( $string )
    {
        $stringBuilder = "";
        $offset = 0;
        if ( empty( $string ) ) {
            return "";
        }
        while ( $offset >= 0 ) {
            $decValue = $this->ordutf8( $string, $offset );
//            print $decValue.PHP_EOL;
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

    public function hex()
    {
        return function($emojis){
            if($emojis){
                foreach($emojis as &$match) {    
                }
                return $match;
            }
        };
    }
    
    public function clean()
    {
        return function($emojis){
            if($emojis){
                foreach($emojis as &$match) {    
                    $match = '';
                }
                return $match;
            }
        };
    }
    
    public function dec()
    {
        return function($emojis){
            if($emojis)
                foreach($emojis as &$match){
                    $match= $this->entities($match);       
                }
            return $match;
        };
    }    
}
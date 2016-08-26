<?php 
require_once "Detector.php";
require_once "EmojiUnicode.php";
class EmojiDetector implements Detector,EmojiUnicode
{
    //convert unicode to character
//    private function unichr($i) {
//        return iconv('UCS-4LE', 'UTF-8', pack('V', $i));
//    }
    
    private function entities( $string )
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

    // source - http://php.net/manual/en/function.ord.php#109812
    private function ordutf8($string, &$offset) {
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
    
    // source - http://php.net/manual/en/function.chr.php#88611
    private function unichr($u) {
        return mb_convert_encoding('&#'.intval($u).';','UTF-8','HTML-ENTITIES');
    }
    
    public function ncrhex()
    {
        return function($emojis){
            if($emojis)
                foreach($emojis as &$match){
//                    $match = mb_convert_encoding('&#'.$u.';','UTF-8','HTML-ENTITIES');;       
                }
                return $match;
        };
    }
    
    public function ncrdec()
    {
        return function($emojis){
            if($emojis)
                foreach($emojis as &$match){
                    $match= $this->entities($match);       
                }
            return $match;
        };
    }
    
    public function unicode()
    {
         return function($emojis){
            if($emojis)
                foreach($emojis as &$match){
                    $match='unicode';       
                }
            return $match;
         };
    }
    
    public function symbol()
    {
         return function($emojis){
            if($emojis)
                foreach($emojis as &$match){
                    $match='symbol';       
                }
            return $match;
         };
    }
    
    public function detect($text)
    {
        
    }
    
    public function replace($text,$format)
    {
        if(!$format) return $text;
        try{
            switch($format){
                case 'ncrhex':$callback = $this->ncrhex();break;
                case 'ncrdec':$callback = $this->ncrdec();break;
//                case 'dec':$callback = $this->dec();break;
//                case 'hex':$callback = $this->hex();break;
                case 'symbol':$callback = $this->symbol();break;
                case 'unicode':$callback = $this->unicode();break;
                case 'clean':$callback = $this->clean();break;
                default:$callback = null;
            }
            if(!$callback) return $text;//or throw exception
            $pattern = '/['.$this->unichr(0x1F300).'-'.$this->unichr(0x1F5FF).$this->unichr(0xE000).'-'.$this->unichr(0xF8FF).']/u';
            $replace = preg_replace_callback($pattern,$callback,$text);
        }catch(Exception $e){
            return $text;
        }
        return $replace;
    }
}
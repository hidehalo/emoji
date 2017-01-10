<?php
namespace Hidehalo\String\Emoji;
require_once "Adapter.php";
use Hidehalo\String\Emoji\Adapter;
class HtmlAdapter extends Adapter
{    
    
    private function hex()
    {
        return function($emojis) {
            if($emojis){
                foreach($emojis as &$match) {    
                    $match = $this->entities($match,1);  
                }
                return $match;
            }
        };
    }
    
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
    
    protected function mbunichr($code)
    {
        //convert Unicode to UTF-8 encoding character
        $character = mb_convert_encoding('&#'.$code.';','UTF-8','HTML-ENTITIES');
        return $character;
    }
    
    public function unichr($code)
    {
        //convert Unicode to UTF-8 encoding character
        $character = iconv('UCS-4LE', 'UTF-8', pack('V', $code));
        return $character;
    }


    
    public function __construct()
    {

    }
    
    public function detect($text)
    {
        $emojis=false;
        $pattern = $this->getPattern();
        preg_match_all($pattern,$text,$emojis);
        return $emojis;
    }
    
    public function replace($text,$format)
    {
        if(!$format) return $text;
        try{
            switch($format){
                case 'hex':$callback = $this->hex();break;
                case 'dec':$callback = $this->dec();break;
                case 'clean':$callback = $this->clean();break;
                default:$callback = null;
            }
            if(!$callback) return $text;//or throw exception
            $pattern = $this->getPattern();
            $replace = @preg_replace_callback($pattern,$callback,$text);
        } catch(Exception $e) {
            return $text;
        }
        return $replace;
    }
 
}

$h = new HtmlAdapter();
$offset = 0;
$str = '😂';
echo $h->ordutf8($str,$offset);
<?php
/**
 * Created by PhpStorm.
 * User: TianChen
 * Date: 16/12/8
 * Time: 22:09
 */

namespace Hidehalo\Emoji;

class Core
{
    /**
     * character to ascii value
     * @src - http://php.net/manual/en/function.ord.php#109812
     */
    public function ordutf8($string, $offset = 0)
    {
        if ($offset >= strlen($string)) {
            return -1;
        }

        $ascii = ord(substr($string, $offset,1));

        if ($ascii > 0x7f) {
            switch($ascii&0xf0){
                case 0xf0:$bytesnumber = 4;break;
                case 0xe0:$bytesnumber = 3;break;
                case 0xd1:;
                case 0xd0:$bytesnumber = 2;break;
                default:throw new \Exception('Invalid UTF-8 Character');
            }
            for($i = 1,$code = $ascii;$i<$bytesnumber;$i++){
               $code =  ($code << 6)|ord(substr($string,$offset+$i,1));
            }

            return $code;
        }

        return $ascii;
    }
}

$t = new Core();
$offset = 0;
$str = '😂';
echo 'ascii:0x'.dechex($t->ordutf8($str,$offset)).PHP_EOL;


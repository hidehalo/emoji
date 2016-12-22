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
     * @param string $string 
     * @param integer $offset 
     */
    function getUnicodeValue($unichar,$bytesnumber)
    {
        $offset = 0;
        $highChar = substr($unichar, $offset ,1);
        $ascii = ord($highChar);
        if ($bytesnumber>1) {
            $code = ($ascii) & (2 ** (7 - $bytesnumber) - 1);
            for ($i = 1;$i<$bytesnumber;$i++) {
                $char = substr($unichar, $offset + $i, 1);
                $code =  ($code << 6) | (ord($char) & 0x3f);
            }
            $ascii = $code;
        }
        
        return $ascii;
    }

    /**
     * get Unicode bytes number
     */
    function getBytesNumber($char)
    {
        $ascii = ord($char);
        $bytesnumber = 1;
        if ($ascii > 0x7f) {
            switch ($ascii&0xf0) {
                case 0xfd:
                    $bytesnumber = 6;
                    break;
                case 0xf8:
                    $bytesnumber = 5;
                    break;
                case 0xf0:
                    $bytesnumber = 4;
                    break;
                case 0xe0:
                    $bytesnumber = 3;
                    break;
                case 0xd1:;
                case 0xd0:
                    $bytesnumber = 2;
                    break;
            }
        }

        return $bytesnumber;
    }
    
    /**
     * get Unicodes array by string
     */
    function unicodeString($string,$rules = array())
    {
        $len = strlen($string);
        $unicode = [];
        $offset = 0;
        while($offset < $len){
            $highChar = substr($string, $offset,1);
            $bytesnumber = $this->getBytesNumber($highChar);
            $unichar = substr($string , $offset ,$bytesnumber);
            $offset += $bytesnumber;
            $unicode[] = $this->getUnicodeValue($unichar,$bytesnumber);
        }
        
        return $unicode;
    }
}

$t = new Core();
$offset = 0;
$str = '😂,😂,😂,😂';
print_r($t->unicodeString($str));


<?php
/**
 * Created by PhpStorm.
 * User: TianChen
 * Date: 16/12/8
 * Time: 22:09
 */

namespace Hidehalo\Emoji;
use Hidehalo\Emoji\Feature\FeatureInterface;
use Hidehalo\Emoji\Unicode\Emoji;

class Core extends Emoji implements FeatureInterface
{
    private $detector;
    private $adapter;

    /**
     * get unicode array from string
     * @param string $string
     * @return array $unicode
     */
    function unicodeArray($string)
    {
        $len = strlen($string);
        $unicode = [];
        $offset = 0;
        while($offset < $len){
            $highChar = substr($string, $offset,1);
            $bytesNumber = $this->getBytesNumber($highChar);
            $symbol = substr($string , $offset ,$bytesNumber);
            $offset += $bytesNumber;
            $unicode[] = $this->getUnicode($symbol,$bytesNumber);
        }

        return $unicode;
    }

}


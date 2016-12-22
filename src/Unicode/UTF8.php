<?php

namespace Hidehalo\Emoji\Unicode;

abstract class UTF8 implements Unicode
{
    /**
     * character of unicode symbol convert to unicode value
     * @param string $symbol
     * @param integer $bytes
     * @return integer $ascii
     */
    function getUnicode($symbol,$bytes = 1)
    {
        $offset = 0;
        $highChar = substr($symbol, $offset ,1);
        $ascii = ord($highChar);
        if ($bytes > 1) {
            $code = ($ascii) & (2 ** (7 - $bytes) - 1);
            for ($i = 1;$i<$bytes;$i++) {
                $char = substr($symbol, $offset + $i, 1);
                $code =  ($code << 6) | (ord($char) & 0x3f);
            }
            $ascii = $code;
        }

        return $ascii;
    }

    /**
     * get Unicode symbol bytes number
     * @param string $symbol
     * @return integer $bytesNumber
     */
    function getBytesNumber($symbol)
    {
        $ascii = ord($symbol);
        $bytesNumber = 1;
        if ($ascii > 0x7f) {
            switch ($ascii&0xf0) {
                case 0xfd:
                    $bytesNumber = 6;
                    break;
                case 0xf8:
                    $bytesNumber = 5;
                    break;
                case 0xf0:
                    $bytesNumber = 4;
                    break;
                case 0xe0:
                    $bytesNumber = 3;
                    break;
                case 0xd1:
                case 0xd0:
                    $bytesNumber = 2;
                    break;
            }
        }

        return $bytesNumber;
    }

    /**
     * @param $symbol
     */
    function getBytes($symbol)
    {
        $bytesNumber = $this->getBytesNumber($symbol);
        $bytes = [];
        for ($i=0; $i<$bytesNumber; $i++) {
            $bytes[] = ord(substr($symbol,$i,1));
        }
    }

    abstract function getNative($unicode);
}
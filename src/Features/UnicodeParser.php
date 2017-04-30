<?php

namespace Hidehalo\Emoji\Features;

abstract class UnicodeParser implements ParserInterface
{
    /**
     * get native emoji symbol by unicode.
     *
     * @param $unicode
     *
     * @return string $symbol
     */
    public static function getSymbol($unicode)
    {
        $symbol = iconv('UCS-4LE', 'UTF-8', pack('V', $unicode));

        return $symbol;
    }

    /**
     * character of unicode symbol convert to unicode value.
     *
     * @param string $symbol
     * @param int    $bytes
     *
     * @return int $ascii
     */
    public static function getUnicode($symbol, $bytes = 1)
    {
        $offset = 0;
        $highChar = substr($symbol, $offset, 1);
        $ascii = ord($highChar);
        if ($bytes > 1) {
            $code = ($ascii) & (2 ** (7 - $bytes) - 1);
            for ($i = 1; $i < $bytes; $i++) {
                $char = substr($symbol, $offset + $i, 1);
                $code = ($code << 6) | (ord($char) & 0x3f);
            }
            $ascii = $code;
        }

        return $ascii;
    }

    /**
     * get Unicode symbol bytes number.
     *
     * @param string $symbol
     *
     * @return int $bytesNumber
     */
    public static function getBytesNumber($symbol)
    {
        $ascii = ord($symbol);
        $bytesNumber = 1;
        if ($ascii > 0x7f) {
            switch ($ascii & 0xf0) {
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
    public static function getBytes($symbol)
    {
        $bytesNumber = self::getBytesNumber($symbol);
        $bytes = [];
        for ($i = 0; $i < $bytesNumber; $i++) {
            $bytes[] = ord(substr($symbol, $i, 1));
        }

        return $bytes;
    }
}

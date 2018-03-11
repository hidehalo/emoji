<?php

/**
 * Count UTF-8 btyes number
 *
 * @param string $unicode
 * @return integer
 */
function bytes_cnt($unicode)
{
    $head = intval($unicode);
    $number = 1;
    $bitsmask = ($head & 0xf0);
    if ($bitsmask >= 0x80) {
        switch ($bitsmask) {
            case 0xf0:
                $number = 4;
                break;
            case 0xe0:
                $number = 3;
                break;
            case 0xc0:
                $number = 2;
                break;
        }
    }

    return $number;
}

/**
 * Utf8 to unicode codepoint
 *
 * @param string $unicode
 * @return integer
 */
function utf8_to_cop($unicode)
{
    $offset = 0;
    $head = substr($unicode, $offset, 1);
    $ascii = ord($head);
    $num = bytes_cnt($ascii);
    if ($num > 1) {
        $codepoint = $ascii & ((1<<(7 - $num)) - 1);
        for ($i = 1; $i < $num; $i++) {
            $char = ord(substr($unicode, $offset + $i, 1));
            $codepoint = ($codepoint << 6) | ($char & 0x3f);
        }

        return $codepoint;
    }

    return $ascii;
}

/**
 * Unicode codepoint to utf8
 *
 * @param integer $codepoint
 * @return string
 */
function cop_to_utf8($codepoint)
{
    $symbol = iconv('UCS-4BE', 'UTF-8', pack('N', $codepoint));

    return $symbol;
}

/**
 * Cursor of utf8 encode string
 *
 * @param string $string
 * @return Generator
 */
function utf8_cursor($string)
{
    $size = strlen($string);
    for ($i=0, $step=bytes_cnt(ord($string[$i]));
        $i<$size;
        $i+=$step, $step=bytes_cnt(ord(@$string[$i]))
    ) {
        yield substr($string, $i, $step);
    }
}
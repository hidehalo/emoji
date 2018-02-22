<?php

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

function codepoint($unicode)
{
    $offset = 0;
    $head = substr($unicode, $offset, 1);
    $ascii = ord($head);
    $num = bytes_cnt($ascii);
    if ($num > 1) {
        $codepoint = $ascii & (2^(7 - $num) - 1);
        for ($i = 1; $i < $num; $i++) {
            $char = substr($unicode, $offset + $i, 1);
            $codepoint = ($codepoint << 6) | (ord($char) & 0x3f);
        }
        
        return $codepoint;
    }

    return $ascii;
}

function unicode($codepoint)
{
    $symbol = iconv('UCS-4LE', 'UTF-8//TRANSLIT', pack('V', $codepoint));

    return $symbol;
}
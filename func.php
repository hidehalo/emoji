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

function utf8_to_cop($unicode)
{
    $offset = 0;
    $head = substr($unicode, $offset, 1);
    $ascii = ord($head);
    $num = bytes_cnt($ascii);
    // var_dump(dechex($ascii));
    if ($num > 1) {
        $codepoint = $ascii & ((1<<(7 - $num)) - 1);
        for ($i = 1; $i < $num; $i++) {
            $char = ord(substr($unicode, $offset + $i, 1));
            $codepoint = ($codepoint << 6) | ($char & 0x3f);
            // var_dump(dechex($char));
        }
        // var_dump($codepoint);
        return $codepoint;
    }

    return $ascii;
}

function cop_to_utf8($codepoint)
{
    $symbol = iconv('UCS-4LE', 'UTF-8', pack('V', $codepoint));

    return $symbol;
}

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
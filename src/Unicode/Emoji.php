<?php

namespace Hidehalo\Emoji\Unicode;

class Emoji extends UTF8
{
    public function __construct($symbol = '', $bytes = [], $unicode = null, $bytesNumber = 1)
    {
        parent::__construct($symbol, $bytes, $unicode, $bytesNumber);
    }

    public function getUnicode()
    {
        return $this->unicode;
    }

    public function getBytesNum()
    {
        return $this->bytesNumber;
    }

    public function getBytes()
    {
        return $this->bytes;
    }

    public function getSymbol()
    {
        return $this->symbol;
    }
}

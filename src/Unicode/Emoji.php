<?php

namespace Hidehalo\Emoji\Unicode;

class Emoji extends UTF8
{
    public function __construct($symbol = '', $bytes = [], $unicode = null, $bytesNumber = 1)
    {
        parent::__construct($symbol, $bytes, $unicode, $bytesNumber);
    }
}

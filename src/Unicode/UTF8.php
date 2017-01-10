<?php

namespace Hidehalo\Emoji\Unicode;

class UTF8 implements Unicode
{
    protected $unicode = null;
    protected $bytes = [];
    protected $symbol = '';
    protected $bytesNumber = 1;

    function __construct($symbol = '',$bytes =[],$unicode = null,$bytesNumber = 1)
    {
        $this->bytes = $bytes;
        $this->bytesNumber = $bytesNumber;
        $this->symbol =$symbol;
        $this->unicode = $unicode;
    }
}
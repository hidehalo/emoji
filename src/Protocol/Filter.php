<?php

namespace Hidehalo\Emoji\Protocol;

class Filter implements ProtocolInterface
{
    use PatternAwareTrait;

    public function encode($contents)
    {
       return '';
    }

    public function decode($contents)
    {
        return '';
    }
}
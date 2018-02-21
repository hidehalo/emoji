<?php

namespace Hidehalo\Emoji\Protocol;

trait PatternAwareTrait
{
    public function getPattern()
    {
        return $this->pattern;
    }

    public function getFormat()
    {
        return $this->format;
    }
}
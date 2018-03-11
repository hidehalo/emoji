<?php

namespace Hidehalo\Emoji\Protocol;

trait PatternAwareTrait
{
    /**
     * @inheritDoc
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @inheritDoc
     */
    public function getFormat()
    {
        return $this->format;
    }
}
<?php

namespace Hidehalo\Emoji\Protocol;

class Filter implements ProtocolInterface
{
    use PatternAwareTrait;

    /**
     * @inheritDoc
     */
    public function encode($contents)
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function decode($contents)
    {
        return '';
    }
}
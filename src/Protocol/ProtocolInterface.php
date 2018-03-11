<?php

namespace Hidehalo\Emoji\Protocol;

interface ProtocolInterface
{
    /**
     * Encode contents
     *
     * @param string $contents
     * @return string
     */
    public function encode($contents);

    /**
     * Decode contents
     *
     * @param string $contents
     * @return string
     */
    public function decode($contents);

    /**
     * Get tmplate regex pattern
     *
     * @return void
     */
    public function getPattern();

    /**
     * Get string replace tmplate
     *
     * @return void
     */
    public function getFormat();
}

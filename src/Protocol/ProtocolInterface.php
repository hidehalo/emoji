<?php

namespace Hidehalo\Emoji\Protocol;

interface ProtocolInterface
{
    public function encode($contents);

    public function decode($contents);

    public function getPattern();

    public function getFormat();
}

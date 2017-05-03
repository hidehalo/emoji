<?php

namespace Hidehalo\Emoji\Features\Protocol;

interface ProtocolInterface
{
    public function encode($contents, array $options = []);

    public function decode($contents, array $options = []);

    public function getPattern();
}

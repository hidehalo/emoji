<?php

namespace Hidehalo\Emoji;

use Hidehalo\Emoji\Parser;
use Hidehalo\Emoji\Protocol\Utf8String;
use Hidehalo\Emoji\Protocol\ProtocolInterface as Protocol;

class Converter
{
    public function __construct(Parser $parser, Protocol $proto = null)
    {
        $this->parser = $parser;
        $this->protocol = $proto?:new Utf8String;
    }

    /**
     * Encode via convert protocol
     *
     * @param string $string
     * @param Protocol $proto
     * @return string
     */
    public function encode($string, Protocol $proto = null)
    {
        $proto = $proto?: $this->protocol;
        $handler = function ($elms) use ($proto) {
            $size = count($elms);
            if ($size > 0) {
                for ($i = 0; $i < $size; $i++) {
                    $elms[$i] = $proto->encode($elms[$i]);
                }
            }

            return implode('', $elms);
        };
        $pattern = $this->parser->getPattern();
        $result = false;
        if ($pattern) {
            $result = preg_replace_callback($pattern, $handler, $string);
        }

        return $result!==false? $result: $string;
    }

    /**
     * Decode via convert protocol
     *
     * @param string $string
     * @param Protocol $proto
     * @return string
     */
    public function decode($string, Protocol $proto = null)
    {
        $proto = $proto?: $this->protocol;
        $handler = function ($elms) use ($proto) {
            $size = count($elms);
            if ($size > 0) {
                for ($i = 0; $i < $size; $i++) {
                    $elms[$i] = $proto->decode($elms[$i]);
                }
            }

            return implode('', $elms);
        };
        $pattern = $proto->getPattern();
        $result = false;
        if ($pattern) {
            $result = preg_replace_callback($pattern, $handler, $string);
        }

        return $result!==false? $result: $string;
    }
}
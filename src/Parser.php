<?php

namespace Hidehalo\Emoji;

use Hidehalo\Emoji\Protocol\Utf8String;
use Hidehalo\Emoji\Protocol\ProtocolInterface as Protocol;

class Parser
{
    public function __construct(Protocol $proto = null)
    {
        $this->protocol = $proto?:new Utf8String;
        $this->pattern = (new RegexBuilder(__DIR__.'/../data/emoji.cache'))->complie();
    }

    public function parse($string)
    {
        $ret = preg_match_all($this->pattern, $string, $matches);
       
        return $ret? $matches: false;
    }

    public function encode($string, Protocol $proto = null)
    {
        $proto = $proto?: $this->protocol;
        $handler = function ($elms) use ($proto) {
            $size = count($elms);
            if ($size > 0) {
                for ($i = 0; $i < $size; $i++) {
                    $elms[$i] = $proto->encode($elms[$i]);

                    return $elms[$i];
                }
            }
        };
        $result = preg_replace_callback($this->pattern, $handler, $string);
        
        return $result?: $string;
    }

    public function decode($string, Protocol $proto = null)
    {
        $proto = $proto?: $this->protocol;
        $handler = function ($elms) use ($proto) {
            $size = count($elms);
            if ($size > 0) {
                for ($i = 0; $i < $size; $i++) {
                    $elms[$i] = $proto->decode($elms[$i]);

                    return $elms[$i];
                }
            }
        };
        if (($pattern = $proto->getPattern())) {
            $result = preg_replace_callback($pattern, $handler, $string);
        }
        
        return $result?: $string;
    }
}

require __DIR__.'/../vendor/autoload.php';

$p = new Parser;
$str = '😬';
$ret = $p->parse($str);
$ret = $p->encode($str);
print_r($ret);
print_r($p->decode($ret));


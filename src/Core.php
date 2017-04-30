<?php

namespace Hidehalo\Emoji;

use Hidehalo\Emoji\Features\EmojiParser;
use Hidehalo\Emoji\Features\ParserInterface;
use Hidehalo\Emoji\Features\Protocol\ProtocolInterface;
use Hidehalo\Emoji\Features\Protocol\Utf8String;
use Hidehalo\Emoji\Features\ProtocolFactory;

class Core
{
    /**
     * @var ProtocolInterface
     */
    protected $protocol;

    /**
     * @var ParserInterface
     */
    protected $parser;

    public function __construct($options = [])
    {
        $protocolName = (isset($options['protocol_name'])) ? $options['protocol_name'] : Utf8String::class;
        $this->parser = new EmojiParser();
        $this->protocol = ProtocolFactory::generate($protocolName);
    }

    public function clean($string)
    {
        return $this->parser->clean($string);
    }

    public function parse($string)
    {
        return $this->parser->parse($string);
    }

    public function encode($string, $options = [])
    {
        $protocol = $this->protocol;
        $encodeString = $this->parser->replace($string, function ($matches) use ($protocol, $options) {
            if (is_array($matches) && !empty($matches)) {
                foreach ($matches as &$matched) {
                    $matched = $protocol->encode($matched, $options);

                    return $matched;
                }
            }

            return '';
        });

        return $encodeString;
    }

    public function decode($string, $options = [])
    {
        $protocol = $this->protocol;
        $decodeString = $this->parser->replace($string, function ($matches) use ($protocol, $options) {
            if (is_array($matches) && !empty($matches)) {
                foreach ($matches as &$matched) {
                    $matched = $protocol->decode($matched, $options);

                    return $matched;
                }
            }

            return '';
        }, $protocol->getPattern());

        return $decodeString;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: TianChen
 * Date: 16/12/8
 * Time: 22:09
 */

namespace Hidehalo\Emoji;

use Hidehalo\Emoji\Features\EmojiParser;

class Core
{
    function __construct()
    {
        $this->parser = new EmojiParser();
    }

    function filter($string)
    {
        $result = $this->parser->buildRegex()->clean($string);

        return $result;
    }
}


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
    public function __construct()
    {
        $this->parser = new EmojiParser();
    }

    public function filte($string)
    {
        return $this->parser->clean($string);
    }
}


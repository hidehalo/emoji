<?php

namespace Hidehalo\Emoji\Unicode;

abstract class Emoji extends UTF8
{
    protected $unicode;
    protected $bytes = [];
    protected $description = [];

    function getNative($unicode)
    {
        // TODO: Implement getNative() method.
    }


}
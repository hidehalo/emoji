<?php

namespace Hidehalo\Emoji\Unicode;

interface Unicode
{
    function getUnicode($symbol);
    function getNative($unicode);
    function getBytes($symbol);
}